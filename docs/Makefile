all: pdf view
pdf:
	rst2pdf introduction.txt -s manual.style -b1
html:
	rst2html.py introduction.txt > haanga.html
view:
	(evince introduction.pdf & )&

