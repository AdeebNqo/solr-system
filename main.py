import lxml
import sys
import re #regular expressions
import pysolr
import os

class recordtree():
	xml = None
	def __init__(self, filename):
		self.xml = open(filename).read()
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
	xml = open(directory+'/'+afile,'r').read()
	xmltree = lxml.etree.parse(xml)
	root = xmltree.getroot()
	listRecords = root.getchildren()[2]
	records = listRecords.getchildren()

#getting records in from a single file
directory = sys.argv[1]
files = os.listdir(directory)
for File in files:
	records = getrecords(File,directory)
	for record in records:
		print(record)
		break
