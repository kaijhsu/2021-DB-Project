<?php
    include 'db_connect.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Profile</title>
        <style type="text/css">
            body
            {
                font-family: "Arial"
            }
            .head
            {
                background-color: #003344; color: white; font-weight: bold; font-size: 50px;
                text-align: center; padding: 10px;
            }
            .box
            {
                width: 1000px; padding: 10px; margin: auto;
                background-color: white; vertical-align: center;

                text-align: center;
            }
            #btn
            {
                font-size: 20px
            }
            table
            {
                width: 800px; border: 1px solid #000000;
                border-collapse: collapse;
                word-break: break-word;
                table-layout: fixed;
                margin: auto;
                font-size: 15px;
            }
            td
            {
                border: 1px solid #000000; padding: 10px;
            }
            tr:nth-child(odd)
            {
                background-color: #7788aa; color: #ffffff;
            }
            
        </style>
    </head>

    <body style="margin: 0px; background-color: #eeeeee;">
        <div class="head">Profile</div>
            <?php
                $message = ""; // error message
                if( isset($_POST['search']) )
                {
                    // Get data from post
                    $year =  mysqli_real_escape_string($connect, $_POST['Year']);
                    $name =  mysqli_real_escape_string($connect, $_POST['Name']);
                    // SQL query
                    $sql = "SELECT nameFirst, nameLast, height, weight, birthYear, birthMonth, birthDay, deathYear, deathMonth, deathDay
                            FROM MASTER 
                            WHERE nameGiven='$name';";
                    $result = mysqli_query($connect, $sql);
                    $resultcheck = mysqli_num_rows($result);
                    echo '<div class="box">
                        <table class="tab1">
                            <tr>
                                <td>NAME</td>
                                <td>Height</td>
                                <td>Weight</td>
                                <td>Birthday</td>
                                <td>Deathday</td>
                            </tr>';
                    if($resultcheck>0)
                    {
                        foreach($result as $row)
                        {//playerID,birthYear,birthMonth,birthDay,birthCountry,birthState,birthCity,deathYear,deathMonth,deathDay,deathCountry,deathState,deathCity,nameFirst,nameLast,nameGiven,weight,height,bats,throws,debut,finalGame,retroID,bbrefID
                            echo "<tr>
                                <td>".$row['nameFirst'].", ".$row['nameLast']."</td>
                                <td>".$row['height']."</td>
                                <td>".$row['weight']."</td>
                                <td>".$row['birthYear']."-".$row['birthMonth']."-".$row['birthDay']."</td>
                                <td>".$row['deathYear']."-".$row['deathMonth']."-".$row['deathday']."</td>
                            </tr>";
                        }
                    }
                    else{
                        echo "<tr>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                        </tr>";
                    }

                    $sql = "SELECT bats, throws, birthCountry, 
                                IF(deathYear=0 AND birthYear!=0, 2021-birthYear,deathYear-birthYear) age
                            FROM MASTER
                            WHERE nameGiven='$name';";
                    $result = mysqli_query($connect, $sql);
                    $resultcheck = mysqli_num_rows($result);
                    echo "<tr>
                        <td>Bats</td>
                        <td>Throws</td>
                        <td>Age</td>
                        <td>Country</td>
                    </tr>";
                    if($resultcheck>0)
                    {
                        foreach($result as $row)
                        {
                            echo "<tr>
                                <td>".$row['bats']."</td>
                                <td>".$row['throws']."</td>
                                <td>".$row['age']."</td>
                                <td>".$row['birthCountry']."</td>
                            </tr>";
                        }
                        
                    }
                    else
                    {
                        echo "<tr>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                        </tr>";    
                    }
                    echo "</table>
                    </div>";
                    
                    // second query
                    $sql = "SELECT b.yearID, b.teamID, b.G, b.AB, b.H, b.2B, b.3B, b.HR, b.RBI, b.R, b.SB, b.SO, b.BB
                            FROM Batting b,
                                (SELECT playerID
                                FROM MASTER
                                WHERE nameGiven='$name') as m
                            WHERE m.playerID=b.playerID AND b.yearID=$year;";
                    // echo '<p>'.$sql.'</p>';
                    $result = mysqli_query($connect, $sql);
                    $resultcheck = mysqli_num_rows($result);
                    echo '<div class="box">
                        <h2>Batting Stats</h2>
                        <table>
                            <tr>
                                <td>Year</td>
                                <td>Team</td>
                                <td>G</td>
                                <td>AB</td>
                                <td>H</td>
                                <td>2B</td>
                                <td>3B</td>
                                <td>HR</td>
                                <td>RBI</td>
                                <td>R</td>
                                <td>SB</td>
                                <td>SO</td>
                                <td>BB</td>
                            </tr>';
                    if($resultcheck>0)
                    {
                        foreach($result as $row)
                        {//playerID,yearID,stint,teamID,lgID,G,AB,R,H,2B,3B,HR,RBI,SB,CS,BB,SO,IBB,HBP,SH,SF,GIDP
                            echo "<tr>
                                <td>".$row['yearID']."</td>
                                <td>".$row['teamID']."</td>
                                <td>".$row['G']."</td>
                                <td>".$row['AB']."</td>
                                <td>".$row['H']."</td>
                                <td>".$row['2B']."</td>
                                <td>".$row['3B']."</td>
                                <td>".$row['HR']."</td>
                                <td>".$row['RBI']."</td>
                                <td>".$row['R']."</td>
                                <td>".$row['SB']."</td>
                                <td>".$row['SO']."</td>
                                <td>".$row['BB']."</td>
                            </tr>";
                        }
                    }
                    else
                    {
                        echo "<tr>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                        </tr>";   
    
                    }
                    echo "</table>
                    </div>";
                    
                // third query
                $sql = "SELECT f.yearID, f.teamID, f.POS, f.InnOuts, f.PO, f.A, f.E, f.DP, f.PB
                    FROM Fielding f,
                        (SELECT playerID
                        FROM MASTER
                        WHERE nameGiven='$name') as m
                    WHERE m.playerID=f.playerID AND f.yearID=$year;";
                $result = mysqli_query($connect, $sql);
                $resultcheck = mysqli_num_rows($result);
                echo '<div class="box">
                    <h2>Fielding Stats</h2>
                    <table>
                        <tr>
                            <td>Year</td>
                            <td>Team</td>
                            <td>Pos</td>
                            <td>InnOuts</td>
                            <td>PO</td>
                            <td>A</td>
                            <td>E</td>
                            <td>DP</td>
                            <td>PB</td>
                        </tr>';
                if($resultcheck>0)
                {
                    foreach($result as $row)
                    {//playerID,yearID,stint,teamID,lgID,POS,G,GS,InnOuts,PO,A,E,DP,PB,WP,SB,CS,ZR
                        echo "<tr>
                            <td>".$row['yearID']."</td>
                            <td>".$row['teamID']."</td>
                            <td>".$row['POS']."</td>
                            <td>".$row['InnOuts']."</td>
                            <td>".$row['PO']."</td>
                            <td>".$row['A']."</td>
                            <td>".$row['E']."</td>
                            <td>".$row['DP']."</td>
                            <td>".$row['PB']."</td>
                        </tr>";
                    }
                }
                else
                {
                    echo "<tr>
                        <td>X</td>
                        <td>X</td>
                        <td>X</td>
                        <td>X</td>
                        <td>X</td>
                        <td>X</td>
                        <td>X</td>
                        <td>X</td>
                        <td>X</td>
                    </tr>";   

                }
                echo "</table>
                </div>";
                    
                // fourth query
                $sql = "SELECT p.yearID, p.teamID, p.W, p.L, p.G, p.IPouts, p.GS, p.GF, p.ER, p.SO, p.WP
                    FROM Pitching p,
                        (SELECT playerID
                        FROM MASTER
                        WHERE nameGiven='$name') as m
                    WHERE m.playerID=p.playerID AND p.yearID=$year;";
                $result = mysqli_query($connect, $sql);
                $resultcheck = mysqli_num_rows($result);
                echo '<div class="box">
                    <h2>Pitching Stats</h2>
                    <table>
                        <tr>
                            <td>Year</td>
                            <td>Team</td>
                            <td>W</td>
                            <td>L</td>
                            <td>G</td>
                            <td>IPouts</td> 
                            <td>GS</td>
                            <td>GF</td>
                            <td>ER</td>
                            <td>SO</td>
                            <td>WP</td>         
                        </tr>';
                if($resultcheck>0)
                {
                    foreach($result as $row)
                    {//playerID,yearID,stint,teamID,lgID,W,,G,GS,CG,SHO,SV,IPouts,H,ER,HR,BB,SO,BAOpp,ERA,IBB,WP,HBP,BK,BFP,GF,R,SH,SF,GIDP
                        echo "<tr>
                            <td>".$row['yearID']."</td>
                            <td>".$row['teamID']."</td>
                            <td>".$row['W']."</td>
                            <td>".$row['L']."</td>
                            <td>".$row['G']."</td>
                            <td>".$row['IPouts']."</td>
                            <td>".$row['GS']."</td>
                            <td>".$row['GF']."</td>
                            <td>".$row['ER']."</td>
                            <td>".$row['SO']."</td>
                            <td>".$row['WP']."</td>
                        </tr>";
                    }
                    
                }
                else
                {
                    echo "<tr>
                        <td>X</td>
                        <td>X</td>
                        <td>X</td>
                        <td>X</td>
                        <td>X</td>
                        <td>X</td>
                        <td>X</td>
                        <td>X</td>
                        <td>X</td>
                        <td>X</td>
                        <td>X</td>
                    </tr>";

                }
                echo "</table>
                </div>";

                // fifth query
                $sql = "SELECT p.awardID, p.yearID, p.pointsWon, p.pointsMax, p.votesFirst
                        FROM AwardsSharePlayers p,
                            (SELECT playerID
                            FROM MASTER
                            WHERE nameGiven='$name') as m
                        WHERE m.playerID=p.playerID AND p.yearID=$year;";
                $result = mysqli_query($connect, $sql);
                $resultcheck = mysqli_num_rows($result);
                echo '<div class="box">
                <h2>Award</h2>
                <table>
                    <tr>
                        <td>Award</td>
                        <td>Year</td>
                        <td>PointsWon</td>
                        <td>PointsMax</td>
                        <td>VotesFirst</td>
                    </tr>';
                if($resultcheck>0)
                {
                    foreach($result as $row)
                    {//playerID,yearID,stint,teamID,lgID,W,,G,GS,CG,SHO,SV,IPouts,H,ER,HR,BB,SO,BAOpp,ERA,IBB,WP,HBP,BK,BFP,GF,R,SH,SF,GIDP
                        echo "<tr>
                            <td>".$row['awardID']."</td>
                            <td>".$row['yearID']."</td>
                            <td>".$row['pointsWon']."</td>
                            <td>".$row['pointsMax']."</td>
                            <td>".$row['votesFirst']."</td>
                        </tr>";
                    }
                    
                }
                else
                {
                    echo "<tr>
                        <td>X</td>
                        <td>X</td>
                        <td>X</td>
                        <td>X</td>
                        <td>X</td>
                    </tr>";

                }
                echo "</table>
                </div>";
            }
            ?>
            <div style="text-align: center" >
                <input type="submit" name="delete" value="Delete" />
            </div>
            <!--刪掉這個資料-->
        </div>
        
    </body>
</html>