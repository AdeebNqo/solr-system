from lxml import etree
import sys

afile = sys.argv[1]
xmltree = etree.parse(afile)
root = xmltree.getroot()
listRecords = root.getchildren()[2]
records = listRecords.getchildren()
for record in records:
	print('i have record')
