import sys
import os
import xml.etree.ElementTree as ET
from tempfile import NamedTemporaryFile

def getcompatible(record):
	bit = 1
	recordfields = record.getchildren()
	doc = '<doc>'
	for field in recordfields:
		if (field.tag.endswith('header')):
			headerfields = field.getchildren()
			for headerfield in headerfields:
				if (headerfield.tag.endswith('identifier')):
					doc=doc+'\n<field name="id">{}</field>'.format(headerfield.text.split('/')[-1])
		elif (field.tag.endswith('metadata')):
			metafields = field.getchildren()
			for metafield in metafields:
				if (metafield.tag.endswith('dc')):
					dcfields = metafield.getchildren()
					for dcfield in dcfields:
						doc=doc+'\n<field name="{0}">{1}</field>'.format(dcfield.tag.split('}')[1].encode('utf-8'), dcfield.text.encode('utf-8'))
	doc = doc+'\n</doc>'
	return doc.encode('utf-8')
#
# Method for getting all records from one file
#
def getrecords(afile,directory):
	xmltree = ET.parse(directory+'/'+afile)
	root = xmltree.getroot()
	listRecords = root.getchildren()[2]
	records = listRecords.getchildren()
	return records

#
#getting records in from a single file
directory = sys.argv[1]
files = os.listdir(directory)
for File in files:
	records = getrecords(File,directory)
	numErr=0
	if (records!=None):
		for record in records:
			try:
				record = '<add>\n{}\n</add>'.format(getcompatible(record))
				File = NamedTemporaryFile()
				filename = File.name
				filename = filename.replace('/tmp/','')
				f = open('metadata/{}'.format(filename),'w')
				f.write(record)
				f.close()
				#java -Durl=http://localhost:8983/solr/collection1/update -jar post.jar
				os.system('./post.sh metadata/{}'.format(filename))
			except UnicodeDecodeError:
				numErr=numErr+1
	print("there've been {} errors".format(numErr))

