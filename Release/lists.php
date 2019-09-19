<?php
require_once 'lists.html';

$USFOODS = "Lists/US FOODS/";
$SYSCOSC = "Lists/SYSCO SC/";

if (isset($_GET["deleteUS"])) {
    unlink($_GET["deleteUS"]);
    header('Location: lists.php?service=US+FOODS');
}
else if (isset($_GET["deleteSYSCO"])) {
    unlink($_GET["deleteSYSCO"]);
    header('Location: lists.php?service=SYSCO+SC');
}
else if (isset($_GET["service"])) {
    if ($_GET["service"] == "US FOODS") {
        $dir = scandir('./'.$USFOODS, 1);
        echo "<tr><th><a href='lists.php'><button><- Back</button></a></th>
        <th colspan='2'>US FOODS</th></tr>";
        foreach ($dir as $i) {
            if ($i != "." && $i != "..") {
                echo "<tr><td>$i</td>
                <td><a href='$USFOODS$i' download><button>Download</button></a></td>
                <td><a href='?deleteUS=$USFOODS$i'><button>Delete</button></a></td></tr>";
            }
        }
    }
    if ($_GET["service"] == "SYSCO SC") {
        $dir = scandir('./'.$SYSCOSC, 1);
        echo "<tr><th><a href='lists.php'><button><- Back</button></a></th>
        <th colspan='2'>SYSCO SC</th></tr>";
        foreach ($dir as $i) {
            if ($i != "." && $i != "..") {
                echo "<tr><td>$i</td>
                <td><a href='$SYSCOSC$i' download><button>Download</button></a></td>
                <td><a href='?deleteSYSCO=$SYSCOSC$i'><button>Delete</button></a></td></tr>";
            }
        }
    }
}
else {
    echo "<tr><th><a href='index.php'><button><- Back</th>
    <th></button></a><a href='newlist.php'><button>New List</button></a></th></tr>
    <tr><th><a href='lists.php?service=US+FOODS'><button>US FOODS</button></a></th>
    <th><a href='lists.php?service=SYSCO+SC'><button>SYSCO SC</button></a></th></tr>";
}
echo "</table>";
?>