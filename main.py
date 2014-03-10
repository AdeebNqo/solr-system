import lxml
import sys
import re #regular expressions
import pysolr
import os

class recordtree():
	root = None
	def __init__(self, filename):
		xml = open(filename).read()
	def getdublincore(self):
		return ''
#
#solr stuff
#
solr = pysolr.Solr('http://localhost:8983/solr/')
def indexrecords(docs):
	solr.add(docs)

#
# Method for getting all records from one file
#
def getrecords(afile):
	xmltree = lxml.etree.parse(afile)
	root = xmltree.getroot()
	listRecords = root.getchildren()[2]
	records = listRecords.getchildren()

#getting records in from a single file
directory = sys.argv[1]
files = os.listdir(directory)
for File in files:
	records = getrecords(File)
	for record in records:
		rt = recordtree(record)
		rt.
