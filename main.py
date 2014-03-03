from lxml import etree
import sys
import re #regular expressions
import pysolr
#
# Method for removing nests in xml
#
record_cache = []
def cleanrecord(record):
	children = record.getchildren()
	for item in children:
		if (len(item.getchildren())==0):
			record_cache.append(item)
		else:
			cleanrecord(item)
def indexDoc(doc):
	print('indexing doc...')
	print(doc)
afile = sys.argv[1]
xmltree = etree.parse(afile)
root = xmltree.getroot()
listRecords = root.getchildren()[2]
records = listRecords.getchildren()
for record in records:
	cleanrecord(record)
	doc = ''
	for item in record_cache:
		doc=doc+'\''+item.tag.split('}')[1] +'\' : \''+item.text+'\',\n'
	indexDoc(doc)#index doc
	record_cache = [] #clearing record cache
	break
