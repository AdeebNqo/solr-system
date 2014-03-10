import lxml
import sys
import re #regular expressions
import pysolr

class record(filaname):
	def __init__(self):
		
#solr object
solr = pysolr.Solr('http://localhost:8983/solr/')

record_cache = []
def cleanrecord(record):
	children = record.getchildren()
	for item in children:
		if (len(item.getchildren())==0):
			record_cache.append(item)
		else:
			cleanrecord(item)
def indexrecords(docs):
	print('indexing docs...')
	solr.add(docs)
afile = sys.argv[1]
xmltree = lxml.etree.parse(afile)
root = xmltree.getroot()
listRecords = root.getchildren()[2]
records = listRecords.getchildren()

actualrecords = []
for record in records:
	cleanrecord(record)
	doc = {}
	for item in record_cache:
		doc[item.tag.split('}')[1]] = item.text
	actualrecords.append(doc)
	record_cache = [] #clearing record cache
indexrecords(actualrecords)
