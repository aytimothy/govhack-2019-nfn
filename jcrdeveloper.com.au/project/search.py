import csv
import re

  
# csv file name 
d_loc = "Switching_on_Darwin__Low_Bandwidth_Sensors.csv"
d_var = "City_of_Darwin_Wind_Speed_IoT (1) copy.csv"
  
# initializing the titles and rows list 
fields = [] 
rows = [] 
dl_dict = {}
  
# reading csv file 
with open(d_loc, 'r') as dlcsvfile: 
    dlcsvreader = csv.reader(dlcsvfile) 
    for row in dlcsvreader:
        dl_dict[row[6]] = (row[7],row[8])

with open(d_var, 'r') as dvcsvfile:
    with open('people.csv', 'w') as writeFile:
        dvcsvreader = csv.reader(dvcsvfile)
        for row in dvcsvreader:
            if row[2].split()[-1] in dl_dict:
                r7,r8 = dl_dict[row[2].split()[-1]]
                
                writer = csv.writer(writeFile)
                writer.writerows(row
                                 )
    writeFile.close()

            

dvcsvfile.close()
                        
                




        



"""
import csv 
  
# csv file name 
filename = "aapl.csv"
  
# initializing the titles and rows list 
fields = [] 
rows = [] 
  
# reading csv file 
with open(filename, 'r') as csvfile: 
    # creating a csv reader object 
    csvreader = csv.reader(csvfile) 
      
    # extracting field names through first row 
    fields = csvreader.next() 
  
    # extracting each data row one by one 
    for row in csvreader: 
        rows.append(row) 
  
    # get total number of rows 
    print("Total no. of rows: %d"%(csvreader.line_num)) 
  
# printing the field names 
print('Field names are:' + ', '.join(field for field in fields)) 
  
#  printing first 5 rows 
print('\nFirst 5 rows are:\n') 
for row in rows[:5]: 
    # parsing each column of a row 
    for col in row: 
        print("%10s"%col), 
    print('\n') 
"""
