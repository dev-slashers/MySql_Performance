<?php
    require_once "lib/queryHelper.php";

    $queryHelper = new QueryHelper();

    $maxPopulate = 10000;

    $defaultUpdateName = "default";
    $defaultUpdateSurname = "default";



    echo "<h1>Using Prepared Statements</h1><br>";

    echo "Start at ".$queryHelper->getTime();
    $queryHelper->truncateDatabase();
    echo " - ". $queryHelper->getTime(). " to truncate table<br>";

    echo "Start at ".$queryHelper->getTime();
    $queryHelper->seedDatabase($maxPopulate);
    echo " - ". $queryHelper->getTime(). " to populate table<br>";


    echo "Start at ".$queryHelper->getTime();
    $queryHelper->updateDatabase("defaultST", "defaultST");
    echo " - ". $queryHelper->getTime(). " to update all row with Statements<br>";

    echo "<h1>Using MultiQuery</h1>";


    echo "Start at ".$queryHelper->getTime();
    $queryHelper->updateDatabase_UsingMultiQuery("defaultMT","defaultMT");
    echo " - ". $queryHelper->getTime(). " to update all row with MultiQuery<br>";



    echo "<hr><p>Test on ".$maxPopulate." Query</p>";
