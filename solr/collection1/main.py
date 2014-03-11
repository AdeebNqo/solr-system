import sys
import os
import xml.etree.ElementTree as ET
from tempfile import NamedTemporaryFile

def getcompatible(record):
	bit = 1
	recordfields = record.getchildren()
	doc = '<doc>'
	for field in recordfields:
		if (field.tag.endswith('metadata')):
			metafields = field.getchildren()
			for metafield in metafields:
				if (metafield.tag.endswith('dc')):
					dcfields = metafield.getchildren()
					for dcfield in dcfields:
						if (dcfield.tag.split('}')[1].encode('utf-8')=='identifier' and bit==1):
							bit = 0
							doc=doc+'\n<field name="id">{}</field>'.format(dcfield.text.encode('utf-8'))
						else:
							doc=doc+'\n<field name="{0}">{1}</field>'.format(dcfield.tag.split('}')[1].encode('utf-8'), dcfield.text.encode('utf-8'))
	doc = doc+'\n</doc>'
	return doc
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
	finalrecords = []
	records = getrecords(File,directory)
	if (records!=None):
		for record in records:
			record = getcompatible(record)
			File = NamedTemporaryFile()
			filename = File.name
			filename = filename.replace('/tmp/','')
			f = open('metadata/{}'.format(filename),'w')
			f.write(record)
			f.close()

