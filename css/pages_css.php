<style>
body {
    font-family: "Lato", sans-serif;
    font-size: 14px;
}

table {
    border-collapse: collapse;
}

tr {
    background-color: #f2f2f2;
}

th, th a {
    font-size: 12px;
    background-color: #777;
    color: white;
    padding: 6px 4px 6px 4px;
    white-space: nowrap;
}

td, td a {
    font-size: 12px;
    font-weight: bold;
    color: #444;
    padding: 4px 4px 4px 4px;
    white-space: nowrap;
}

#mainviewtable td {
    border-top: 1px solid #333;
}

.collapsemenu {
    font-size: 14px;
    font-weight: bold;
    background-color: #777;
    color: white;
    cursor: pointer;
    padding: 6px 16px 6px 16px;
    border-radius: 4px;
    border: none;
    text-align: center;
    z-index: 1;
    top: 20px;
    left: 10px;
    width: 180px;
    position: fixed;
}

.active, .collapsemenu:hover {
    background-color: #555;
}

.collapsefilter {
    font-size: 14px;
    font-weight: bold;
    background-color: #777;
    color: white;
    cursor: pointer;
    padding: 6px 6px 6px 6px;
    border: none;
    border-radius: 4px;
    text-align: center;
    z-index: 1;
    top: 20px;
    left: 10px;
    margin-left: 370px;
    width: 180px;
    position: fixed;
}

.active, .collapsefilter:hover {
    background-color: #555;
}

.collapsesearch {
    font-size: 14px;
    font-weight: bold;
    background-color: #777;
    color: white;
    cursor: pointer;
    padding: 6px 16px 6px 16px;
    border: none;
    border-radius: 4px;
    text-align: center;
    z-index: 1;
    top: 20px;
    left: 10px;
    margin-left: 185px;
    width: 180px;
    position: fixed;
}

.active, .collapsesearch:hover {
    background-color: #555;
}

.filternav {
    position: fixed;
    z-index: 1;
    top: 50px;
    left: 10px;
    width: 180px;
    background: #eee;
    overflow-x: hidden;
    padding: 2px 2px;
    border: 1px solid #444444;
    border-radius: 4px;
    display: none;
    margin-left: 370px;
}

.filternav label {
    font-size: 12px;
    font-weight: bold;
    padding: 2px 4px 2px 10px;
    text-decoration: none;
    color: #333;
    display: block;
}

.filternav label:hover {
    font-size: 12px;
    font-weight: bold;
    color: #888;
    cursor: pointer;
}

.filternav p {
    border-style: dashed;
    border-width: 1px;
    border-radius: 4px;
    margin: 6px;
}

.sidenav {
    position: fixed;
    z-index: 1;
    top: 50px;
    left: 10px;
    width: 180px;
    border: 1px solid #444444;
    border-radius: 4px;
    background: #eee;
    overflow-x: hidden;
    padding: 2px 2px;
<?php
if ( isset($_GET["page"]) ) {
    echo "display: none;";
}
else
    echo "display: block;";
?>
}

.sidenav a {
    font-size: 14px;
    font-weight: bold;
    padding: 6px 8px 6px 16px;
    text-decoration: none;
    color: #333;
    display: block;
}

.sidenav a:hover {
    font-size: 14px;
    font-weight: bold;
    color: #888;
}

.collapseform {
    font-size: 14px;
    font-weight: bold;
    background-color: #777;
    color: white;
    cursor: pointer;
    padding: 6px 16px 6px 16px;
    border: none;
    border-radius: 4px;
    text-align: center;
    z-index: 1;
    top: 20px;
    right: 10px;
    width: 180px;
    position: fixed;
}

.active, .collapseform:hover {
    background-color: #555;
}

.main {
    z-index: -1;
    margin-top: 50px;
    border: 1px solid #444444;
    border-radius: 4px;
}

.searchform {
    position: fixed;
    z-index: 1;
    top: 50px;
    left: 10px;
    margin-left: 185px;
    width: 325px;
    border: 1px solid #444444;
    border-radius: 4px;
    overflow-x: hidden;
    display: none;
}

.rightform {
    position: fixed;
    z-index: 1;
    top: 50px;
    right: 10px;
    width: 368px;
    border: 1px solid #444444;
    border-radius: 4px;
    overflow-x: hidden;
<?php
if ( $_GET["action"] == "edit" ) {
    echo "display: block;";
}
else
    echo "display: none;";
?>
}

input[type=text], input[type=date], input[type=datetime-local], select {
    width: 200px;
    border-radius: 4px;
    box-sizing: border-box;
}

input.coltext {
    width: 61px;
}

textarea {
    width: 100%;
    height: 45px;
}

input[type=submit] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    font-weight: bold;
    padding: 5px 10px 5px 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: #45a049;
}

.error {color: #FF0000;}

@media screen and (max-height: 450px) {
    .sidenav {padding-top: 15px;}
    .sidenav a {font-size: 18px;}
}

#loading {
    text-align:center; 
    background: url('loader.gif') no-repeat center; 
    height: 150px;
}

</style>
