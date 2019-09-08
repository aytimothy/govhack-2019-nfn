import csv
import re

  
# csv file name 
d_loc = "Switching_on_Darwin__Low_Bandwidth_Sensors.csv"
d_var = "City_of_Darwin_Temperature_IoT.csv"
d_win = ""

  
# initializing the titles and rows list 
fields = [] 
rows = [] 
dl_dict = {}
  
# reading csv file 
with open(d_loc, 'r') as dlcsvfile: 
    dlcsvreader = csv.reader(dlcsvfile)
    row = next(dlcsvreader)
    for row in dlcsvreader:
        dl_dict[row[6]] = (row[0],row[1])

with open(d_var, 'r') as dvcsvfile:
    with open('outtemp.csv', 'w') as writeFile:
        dvcsvreader = csv.reader(dvcsvfile)
        rows=[]
        n = next(dvcsvreader)
        for n in dvcsvreader:
            #print(n[2])
            row.append(n[0])
            row.append(n[2])
            row.append(n[4])
            row.append(n[5])
            if n[2].split()[-1] in dl_dict:
                lon,lad = dl_dict[n[2].split()[-1]]
                print(dl_dict[n[2].split()[-1]])
                row.append(lon)
                row.append(lad)
                row.append(0)
            else:
                print("12345")
                row.append("lon")
                row.append("lad")
            rows.append(row)

            
                
                
        writer = csv.writer(writeFile)

        writer.writerows(rows)
        
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
