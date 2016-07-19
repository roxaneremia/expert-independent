<?php
session_start();
  include "de-inclus.php";
//echo '<pre>'; print_r($_SESSION); echo '</pre><hr/>'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Despre noi</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!--css-->
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/antet.css" type="text/css" />
  <link rel="stylesheet" href="css/despre-noi.css">
  <link rel="stylesheet" href="css/subsol.css" type="text/css" />

  <!--css-->

  <!--js-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <!--js-->

</head>
<body>
<?php //include "antet.php"; ?>

<div class="container">
<h2>Despre noi</h2>
  <br>
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
      <li data-target="#myCarousel" data-slide-to="3"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img src="img/online-shopping.png" alt="Chania" width="460" height="345">
      </div>

      <div class="item">
        <img src="img/order-online.png" alt="Chania" width="460" height="345">
      </div>
    
      <div class=" item">
        <img src="img/ordering.png" alt="Chania" width="460" height="345">
      </div>

      <div class="item">
        <img src="img/expert-independent.png" alt="Chania" width="460" height="345">
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Anteriorul</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Urmatorul</span>
    </a>
  </div>
</div>
<br/><br/>

<!--Text -->

<div class="container" style="margin-left:5%; margin-right:5%;">
  <em><h3 style="text-align:center; color: #4A424F">Regulile platformei Expert Independent</h3></em>

    <p>Platforma online Expert Independent are ca obiectiv simplificarea si automatizarea unui proces rezultat din necesitatea obtinerii serviciului denumit: achizitionarea de materiale publicitare. Aceasta nevoie se regaseste in principal la persoanele juridice dar nu numai.</p>
    <p>Misiunea platformei, pe langa obiectivul asumat de a automatiza intregul proces de achizitie de materiale publicitare, este de a oferi prin competitie deschisa servicii de design si grafica tot mai bune, dar si de a crea o comunitate de designeri competitivi. Se urmareste pe termen lung, ca efect al utilizarii platformei, sa creasca accesibilitatea oricarei companii catre grafica si design de calitate doar prin cateva clickuri distanta.</p>
    <p>In vederea dezvoltarii platformei online Expert Independent se vor identifica si modela cerintele functionale prin intermediul diagramelor cazurilor de utilizare. Diagramele cazurilor de utilizare prezinta functionalitatile sistemului oferind o descriere generala a modului in care va fi utilizat sistemul de catre actorii care interactioneaza cu acesta. Sistemul interactioneaza cu trei tipuri de actori: administratorul platformei, designer si client.</p> 
    <p>Scenariul platformei este urmatorul: un antreprenor doreste crearea unui material publicitar (flyer,afis, banner, pliant etc.). Clientul este cel care creeaza cont sau se logheaza in platforma, introduce bugetul si cerintele, fisiere (precum logo, text, poze) si lanseaza un concurs cu deadline la care se vor inscrie designerii care au cont in platforma. Bugetul alocat proiectului va fi incasat initial si aprobat de catre platforma. Aprobarea este necesara pentru a evita fraude. Are loc apoi o licitatie de preturi in care fiecare designer interesat de serviciul postat de client propune propriul pret de realizare. Clientul are la dispozitie 24 de ore sa aleaga pretul final. In urma deciderii clientului asupra pretului final al serviciului, concursul incepe. Aceasta licitatie de preturi are loc in intervalul propus de client in momentul publicarii serviciului in platforma.</p> 
    <p>Designerii vor realiza fiecare cate un produs pe care il vor uploada in platforma. Clientul are la dispozitie 10 zile dupa expirarea deadline-ului pentru a desemna un castigator. De asemenea, clientul are posibilitatea sa nominalizeze si castigatori secundari ai concursului, daca solutiile oferite de acestia au fost bune pentru a-i stimula pe acestia sa participe la alte concursuri viitoare propuse de catre clientul respectiv.</p>
    <p>In cazul in care clientul nu va desemna un castigator, bugetul incarcat in platforma va fi distribuit folosind urmatoarea distributie: 10% din pretul final va fi distribuit paltformei, iar restul de 90% se vor reintoarce in contul clientului in cazul in care acesta va aduce argumente relevante pentru decizia luata. Daca insa decizia nu are argumente bine consolidate, 50% din pretul final se imparte intre participanti, 10% procent standard ii revine platformei, iar clientului ii revin 40% din suma.</p>
    <p>In cazul desemnarii unui castigator, distribuirea bugetului se face folosind un algoritm menit sa echilibreze si sa motiveze participantii si sa ofere puncte de feedback. Algoritmul de distribuire al sumei proiectului este complex si presupune luarea in considerare a mai multor criterii.</p>
    <p>a) Desemnarea castigatorilor presupune distributia stelelor in functie de nominalizarile clienului. Castigatorul (furnizorul proiectului) primeste 5 stele (numarul maxim de stele pe care poate sa il primeasca un designer). Clientul poate desemna si alti castigatori de stele oferind un numar de stele intre 1 si 4 din maximul de 20 pe care le are la dispozitie. De asemenea clientul poate desemna de asemenea pe cei care nu s-au incadrat in cerintele sale fiind considerati neconformi cu tema proiectului.</p>
    <p>b) Distribuirea sumei presupune calculul procentelor raportate la suma proiectului  exprimate in valoare absoluta. Astfel ca platformei ii revine 10%, 70% din suma proiectului ii revine castigatorului, iar 20% din suma alocata sunt impartiti in functie de numarul de stele acordate de catre client celorlalti clienti. In cazul in care nu au fost desemnati si alti castigatori acesti 20% ii revin castigatorului, astfel acesta acumuleaza un procent de 90% din pretul final al concursului.</p> 
    <p>Mai departe, dupa obtinerea graficii, clientul va putea downloada documentul pregatit pentru printare, va putea alege serviciile suplimentare puse la dispozitie de catre platforma Expert Independent. In cazul in care clientul opteaza pentru aceste servicii, administratorul contacteaza tipografia partenera. De asemenea clientul mai are posibilitatea de a opta pentru livrarea la domiciliu a produsului. Algoritmul de realizare este acelasi: administratorul contacteaza curierul partener, iar acesta ii ofera informatiile referitoare la costurile serviciului. Apoi administratorul contacteaza clientul si ii furnizeaza informatiile legate de costul total al serviciilor suplimentare pentru care acesta a optat, urmand ulterior sa plateasca pentru acestea pentru confirmarea serviciilor.</p>
    <p>Administratorul platformei are posibilitatea de a modifica statusul unui utilizator (client/designer) din activ in inactiv si invers. Tot el are posibilitatea de a modifica statusul unui concurs in finalizat in cazul in care un client ce a postat un anumit serviciu nu se ocupa de serviciu (nu alege pret, nu alege castigator, etc.). Admin-ul este notificat asupra serviciilor suplimentare alese de client si are posibilitatea schimbarii de informatii cu acesta prin intermediul mesageriei. Administratorul este unic si este singurul ce are acces la statisticile aplicatiei.</p>

</div>


<?php include "subsol.php"; ?>
</body>
</html>
