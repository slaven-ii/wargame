wargame
=======

###Simple php wargame where multiple armies are opposed with each other###

Army can be created with the

    $army = new Army_Army('Army name');
    $army->createArmy(120);

we need to create the war

    $war = new War();

And then give the army to war

    $war->setArmy($army);

There are few logs option:

that will show detailed logs of the battle

    $war->showLogs(true);
   
will adjust the logs for viewing in the browser

    $war->showLogsInHtml(true);



In the end when we are happy with the war and armies we will start the war

    $winner = $war->startWar();


After the war is finished we have Army object with information and can display the results and stats like so:

Army that won the war:  

    $winner->getName()
    
In how many turns the war is won: 

    $war->getTurns()
The remaining units that survived the war: 

    $winner->getArmy()
    
*** In the end: make love not war :) ***
