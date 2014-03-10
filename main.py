import lxml
import sys
import re #regular expressions
import pysolr
import os


def getcompatible(record):
	recordfields = record.getchildren()
	doc = {}
	for field in recordfields:
		if (field.tag.endswith('metadata')):
			metafields = field.getchildren()
			for metafield in metafields:
				if (metafield.tag.endswith('dc')):
					dcfields = metafield.getchildren()
					for dcfield in dcfields:
						doc['{}'.format(dcfield.tag.split('}')[1].encode('utf-8'))] = dcfield.text.encode('utf-8')
	return doc
#
#solr stuff
#
solr = pysolr.Solr('http://localhost:8983/solr/')
def indexrecords(docs):
	solr.add(docs)

#
# Method for getting all records from one file
#
def getrecords(afile,directory):
	xmltree = lxml.etree.parse(directory+'/'+afile)
	root = xmltree.getroot()
	listRecords = root.getchildren()[2]
	records = listRecords.getchildren()
	return records

#getting records in from a single file
directory = sys.argv[1]
files = os.listdir(directory)
for File in files:
	finalrecords = []
	records = getrecords(File,directory)
	if (records!=None):
		for record in records:
			record = getcompatible(record)
			finalrecords.append(record)
	if (len(finalrecords)!=0):
		#print(finalrecords)
		indexrecords(finalrecords)
