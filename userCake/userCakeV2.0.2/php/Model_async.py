import sys, json
import urllib2, urllib
import threading, time
import requests
from time import sleep

def sendToPHP(listid):
    # Load the data that PHP sent us
##    try:
##        data = json.loads(sys.argv[1])
##    except:
##        print "ERROR"
##        sys.exit(1)

    # Generate some data to send to PHP
##    result = {'status': 'Yes!'}
    result = {'Robert J Desinick': '19', 'Karl Elmo': '12'}
    text_file = open(listid[1:-1]+".txt", "w")
    text_file.truncate()
    for expert in result:    
        text_file.write(expert+','+result[expert]+'\n')
    text_file.close()
    # Send it to stdout (to PHP)
##    print json.dumps(result)
    result=urllib.urlencode(result)
    path='http://localhost/expertfinding/index.php'    #the url you want to POST to
    
##    req=urllib2.Request(path, result)
##    req.add_header("Content-type", "application/x-www-form-urlencoded")
    resp = requests.post(path, params=result)
##    page=urllib2.urlopen(req).read()
##    print page
    sleep(0.5)
def main():
    
    lol = {"hej" : 2}
    print lol
    return 2
def postPHP(stuff):
    # Load the data that PHP sent us
##    print stuff[0]
##    try:
##        data = json.loads(stuff)
##    except:
##        print "ERROR"
##        sys.exit(1)

    # Generate some data to send to PHP
    result = {'Robert J Desinick': '19', 'Karl Elmo': '12'}
    sleep(0.3)
    # Send it to stdout (to PHP)
    print json.dumps(result)

if  __name__ =='__main__':
    for i in range(0,1):
        threading.Thread(target=sendToPHP(sys.argv[1])).start()
        

