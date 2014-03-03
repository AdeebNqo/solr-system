from lxml import etree
import sys

afile = sys.argv[1]
xmltree = etree.parse(afile)
for item in xmltree.iter('metadata'):
	print(item)
