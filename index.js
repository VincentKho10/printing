
//13 horizontal
//24 vertical
var tbarr = [];
var row = 13;
var col = 24;

for(var i=0; i < row; i++)
{
    console.log(i);
    var colcont = [];
    for(var j=0; j < col; j++)
    {
        colcont[j] = "";
    }
    tbarr[i] = colcont;
}

var table = document.createElement("table");
var tableBody = document.createElement('tbody');
table.className = "layout";

tbarr.forEach(function(rowData) {
    var ro = document.createElement('tr');
    rowData.forEach(function (cellData){
        var cell = document.createElement('td');
        cell.appendChild(document.createTextNode(cellData));
        ro.appendChild(cell);
    });

    tableBody.appendChild(ro);
});

table.appendChild(tableBody);
document.body.appendChild(table);


