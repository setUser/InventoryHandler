<?php
require_once 'orders.html';

$USFOODS = "Orders/US FOODS/";
$SYSCOSC = "Orders/SYSCO SC/";

if (isset($_GET["deleteUS"])) {
    unlink($_GET["deleteUS"]);
    header('Location: orders.php?service=US+FOODS');
}
else if (isset($_GET["deleteSYSCO"])) {
    unlink($_GET["deleteSYSCO"]);
    header('Location: orders.php?service=SYSCO+SC');
}
else if (isset($_GET["service"])) {
    if ($_GET["service"] == "US FOODS") {
        $dir = scandir('./'.$USFOODS, 1);
        echo "<tr><th><a href='orders.php'><button><- Back</button></a></th>
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
        echo "<tr><th><a href='orders.php'><button><- Back</button></a></th>
        <th colspan='2'>US FOODS</th></tr>";
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
    echo "<tr><th><a href='index.php'><button><- Back</button></a></th>
    <th></button></a><a href='neworder.php'><button>New Order</button></a></th></tr>
    <tr><th><a href='orders.php?service=US+FOODS'><button>US FOODS</button></a></th>
    <th><a href='orders.php?service=SYSCO+SC'><button>SYSCO SC</button></a></th></tr>";
}
echo "</table>";
?>