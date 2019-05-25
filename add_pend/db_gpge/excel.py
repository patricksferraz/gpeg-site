# -*- coding: utf-8 -*-
"""
Spyder Editor

Este é um arquivo de script temporário.
"""

import xlrd
book = xlrd.open_workbook("dados_escola.xls")
sh = book.sheet_by_index(0)

arquivo = open ("registro_escola.sql", "w")

# print (sh.name, sh.nrows, sh.ncols)
#print ("Valor da cécula D30 é ", sh.cell_value(rowx=29, colx=3))

for rx in range(sh.nrows):
# $dat[] = array(0, 'Escola Patrick', 'Itabuna', 'devferraz@gmail.com');
    s = "$dat[] = array(" + str(rx) + ", '" + sh.cell_value(rowx=rx, colx=1) + "', '" + sh.cell_value(rowx=rx, colx=0) + "', '" + (sh.cell_value(rowx=rx, colx=2) if sh.cell_value(rowx=rx, colx=2) != '' else 'devferraz@gmail.com')  + "');\n"
    arquivo.write(s)
    print (sh.row(rx))
    
arquivo.close()