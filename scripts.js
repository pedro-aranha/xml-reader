
function search() {
    var input, filter, table, tr, td, i, txtValue;
    var isset = false;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
       let tds = tr[i].getElementsByTagName("td");
       for (let td of tds) {
           if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                   isset = true;
                }
            }
        }
        if (isset) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
        isset = false;
    }
}

var $table = document.getElementById("myTable"),
$n = 10,
$rowCount = $table.rows.length,
$firstRow = $table.rows[0].firstElementChild.tagName,
$hasHead = ($firstRow === "TH"),
$tr = [],
$i,$ii,$j = ($hasHead)?1:0,
$th = ($hasHead?$table.rows[(0)].outerHTML:"");
var $pageCount = Math.ceil($rowCount / $n);
if ($pageCount > 1) {
	for ($i = $j,$ii = 0; $i < $rowCount; $i++, $ii++)
		$tr[$ii] = $table.rows[$i].outerHTML;
	$table.insertAdjacentHTML("afterend","<div id='buttons' class='pagination'></div");
	ordenar(1);
}

function ordenar($p) {
	var $rows = $th,$s = (($n * $p)-$n);
	for ($i = $s; $i < ($s+$n) && $i < $tr.length; $i++)
		$rows += $tr[$i];
	
	$table.innerHTML = $rows;
	document.getElementById("buttons").innerHTML = Botoes($pageCount,$p);
	document.getElementById("id"+$p).setAttribute("class","active");
}


function Botoes($pCount,$cur) {
	var	$prevDis = ($cur == 1)?"disabled":"",
		$nextDis = ($cur == $pCount)?"disabled":"",
		$buttons = "<input type='button' value='<< Prev' onclick='ordenar("+($cur - 1)+")' "+$prevDis+">";
	for ($i=1; $i<=$pCount;$i++)
		$buttons += "<input type='button' id='id"+$i+"'value='"+$i+"' onclick='ordenar("+$i+")'>";
	$buttons += "<input type='button' value='Next >>' onclick='ordenar("+($cur + 1)+")' "+$nextDis+">";
	return $buttons;
}
