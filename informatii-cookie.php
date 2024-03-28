<?php 
require_once 'core/init.php';
require_once './layout/header.php';

$query = "SELECT * FROM content WHERE pageURL = 'termeni-conditii'";
$results = mysqli_query($db, $query);
$page = mysqli_fetch_object($results);

?>

<!-- Breadscrumb Section -->
<div class="breadcrumb-bar section services" style="padding: 10px">
    <div class="container">
        <div class="row align-items-center text-center">
            <div class="col-md-12 col-12">
                <div class="container">	
                    <!-- /Heading title -->
                    <div class="services-work">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-12" data-aos="fade-down">
                                <div class="services-group">
                                    <div class="services-icon" style="border: 2px dashed #0db02b">
                                        <img class="icon-img" style="background-color: #0db02b" src="assets/img/icons/services-icon-01.svg" alt="Choose Locations">
                                    </div>
                                    <div class="services-content">
                                        <h3 style="color: #0db02b">1. Choose Location</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12" data-aos="fade-down">
                                <div class="services-group">
                                    <div class="services-icon" style="border: 2px dashed #0db02b">
                                        <img class="icon-img" style="background-color: #0db02b" src="assets/img/icons/services-icon-02.svg" alt="Choose Locations">
                                    </div>
                                    <div class="services-content">
                                        <h3 style="color: #0db02b">2. Choose Car</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12" data-aos="fade-down">
                                <div class="services-group">
                                    <div class="services-icon" style="border: 2px dashed #0db02b">
                                        <img class="icon-img" style="background-color: #0db02b" src="assets/img/icons/services-icon-03.svg" alt="Choose Locations">
                                    </div>
                                    <div class="services-content">
                                        <h3 style="color: #0db02b">3. Book a Car</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Breadscrumb Section -->

<section class="section product-details">
    <div class="container">
        <div class="col-md-12">
        <p>
                Acest site utilizează cookie-uri. Informațiile prezentate în continuare au scopul de a aduce la cunoștința utilizatorului mai multe detalii despre plasarea, utilizarea și administrarea "cookie"-urilor utilizate de acest site. Acest website folosește cookie-uri proprii și de la terți pentru a furniza vizitatorilor o experiență mult mai bună de navigare și servicii adaptate nevoilor și interesului fiecăruia. Cookie-urile oferă deținătorilor de site-uri un feedback valoros asupra modului în care sunt utilizate site-urile lor de către utilizatori, astfel încât să le poată face mai eficiente și mai accesibile pentru utilizatori. Îmbunătățesc eficiența publicității online.
</p>
<p></p>
<p>
<strong>Ce este un cookie?</strong>
</p>
<p>
Un "Internet Cookie" (termen cunoscut și ca "browser cookie", "HTTP cookie" sau pur și simplu "cookie" ) este un fișier de mici dimensiuni, format din litere și numere, care va fi stocat pe computerul, terminalul mobil sau alte echipamente ale unui utilizator de pe care se accesează Internetul.
</p>
<p>
Cookie-ul este instalat prin solicitarea emisă de către un web-server unui browser (ex: Internet Explorer, Chrome) și este complet "pasiv" (nu conține programe software, viruși sau spyware și nu poate accesa informațiile de pe hard driveul utilizatorului).
</p>
<p>
Un cookie este format din 2 părți: numele și conținutul sau valoarea cookie-ului. Mai mult, durata de existență a unui cookie este determinată: tehnic, doar web-serverul care a trimis cookie-ul îl poate accesa din nou în momentul în care un utilizator se întoarce pe website-ul asociat web-serverului respectiv.
</p>
<p>
În sine, cookie-urile nu solicită informații cu caracter personal pentru a putea fi utilizate și, în cele mai multe cazuri, nu identifica personal utilizatorii de Internet.
</p>
<p>
Există 2 categorii mari de cookie-uri:
• Cookieuri de sesiune – acestea sunt stocate temporar în dosarul de cookie-uri al browserului web pentru ca acesta să le memoreze până când utilizatorul iese de pe web-site-ul respectiv sau închide fereastra browserului (ex:îin momentul logării/delogării pe un cont de webmail sau pe rețelele de socializare);
• Cookie-uri persistente – acestea sunt stocate pe hard-drive-ul unui computer sau echipament (în general, depinde de durata de viață prestabilită pentru cookie). Cookie-urile persistente le includ și pe cele plasate de un alt web-site decât cel pe care îl vizitează utilizatorul la momentul respectiv – sunt cunoscute sub numele de ‘third party cookies’ (cookieuri plasate de terți) – care pot fi folosite în mod anonim pentru a memora interesele unui utilizator, astfel încât să fie livrată publicitate cât mai relevantă pentru utilizatori.
</p>
<p>
<strong>Care sunt avantajele cookie-urilor?</strong>
</p>
<p>
Un cookie conține informații care fac legătura între un web-browser (utilizatorul) și un web-server anume (website-ul). Dacă un browser accesează acel web-server din nou, acesta poate citi informația deja stocată și reacționa în consecință. Cookie-urile asigură userilor o experiență plăcută de navigare și susțin eforturile multor web-site-uri pentru a oferi servicii confortabile utilizatorillor (ex: preferințele în materie de confidențialitate online, opțiunile privind limba site-ului, coșuri de cumpărături sau publicitate relevantă).
</p>
<p>
<strong>Care este durata de viață a unui cookie?</strong>
</p>
<p>
Cookie-urile sunt administrate de web-servere. Durata de viață a unui cookie poate varia semnificativ, depinzând de scopul pentru care este plasat. Unele cookie-uri sunt folosite exclusiv pentru o singură sesiune (session cookies) și nu mai sunt reținute odată ce utilizatorul a părăsit web-site-ul și unele cookie-uri sunt reținute și refolosite de fiecare dată când utilizatorul revine pe acel website (”cookie-uri permanente”). Cu toate aceste, cookie-urile pot fi șterse de un utilizator în orice moment prin intermediul setărilor browserului.
</p>
<p>
<strong>Ce tip de informații sunt stocate și accesate ?</strong>
</p>
<p>
Cookie-urile păstrează informații într-un fișier text de mici dimensiuni care permit unui website să recunoască un browser. Web-serverul va recunoaște browserul până când cookie-ul expiră sau este șters. Cookie-ul stochează informații importante care îmbunătățesc experiența de navigare pe Internet (ex: setările limbii în care se dorește accesarea unui site, păstrarea unui user logat în contul de webmail, securitatea online banking, păstrarea produselor în coșul de cumpărături).
</p>
<p>
<strong>De ce sunt cookie-urile importante pentru Internet</strong>
</p>
<p>
Cookie-urile reprezintă punctul central al funcționării eficiente a Internetului, ajutând la generarea unei experiențe de navigare prietenoase și adaptată preferințelor și intereselor fiecărui utilizator. Refuzarea sau dezactivarea cookie-urilor poate face unele site-uri imposibil de folosit. Refuzarea sau dezactivarea cookie-urilor nu înseamnă că nu veți mai primi publicitate online – ci doar că aceasta nu va mai putea ține cont de preferințele și interesele dvs. evidențiate prin comportamentul de navigare.
</p>
<p>
<strong>Securitate și probleme legate de confidențialitate</strong>
</p>
<p>
Cookieurile NU sunt viruși! Ele folosesc formate tip plain text. Nu sunt alcătuite din bucăți de cod așa că nu pot fi executate nici nu pot auto-rula. În consecință, nu se pot duplica sau replica pe alte rețele pentru a se rula din nou. Deoarece nu pot îndeplini aceste funcții, nu pot fi considerate viruși. Cookie-urile pot fi totuși folosite pentru scopuri negative. Deoarece stochează informații despre preferințele și istoricul de navigare al utilizatorilor, atât pe un anume site cât și pe mai multe alte site-uri, cookie-urile pot fi folosite ca o formă de Spyware. Multe produse anti-spyware sunt conștiente de acest fapt și în mod constant marchează cookie-urile pentru a fi șterse în cadrul procedurilor de ștergere/scanare antivirus/anti-spyware.
</p>
<p>
În general, browserele au integrate setări de confidențialitate care furnizează diferite nivele de acceptare ale cookie-urilor: perioada de valabilitate și ștergere automată după ce utilizatorul a vizitat un anumit site. Deoarece protecția identității este foarte valoroasă și reprezintă dreptul fiecărui utilizator de Internet, este indicat să se știe ce eventuale probleme pot crea cookie-urile. Pentru că prin intermediul lor se transmit în mod constant, în ambele sensuri, informații între browser și website, dacă un atacator sau o persoană neautorizată intervine în parcursul de transmitere a datelor, informațiile conținute de cookie pot fi interceptate. Deși foarte rar, acest lucru se poate întâmpla dacă browserul se conectează la server folosind o rețea necriptată (ex: o rețea Wi-Fi nesecurizată).
</p>
<p>
Alte atacuri bazate pe cookie implică setări greșite ale cookie-urilor pe servere. Dacă un website nu solicită browserului să folosească doar canale criptate, atacatorii pot folosi această vulnerabilitate pentru a păcăli browserele în a trimite informații prin intermediul canalelor nesecurizate. Atacatorii utilizează apoi informațiile în scopuri de a accesa neautorizat anumite site-uri. Este foarte important să fiți atenți în alegerea metodei celei mai potrivite de protecție a informațiilor personale.
</p>
<p>
<strong>Cum pot opri cookie-urile?</strong>
</p>
<p>
Dezactivarea și refuzul de a primi cookie-uri pot face anumite site-uri impracticabile sau dificil de vizitat și folosit. De asemenea, refuzul de a accepta cookie-uri nu înseamnă că nu veți mai primi/vedea publicitate online.
</p>
<p>
Este posibilă setarea din browser, pentru ca aceste cookie-uri să nu mai fie acceptate sau poți seta browserul să accepte cookie-uri de la un site anume. De exemplu, daca nu ești înregistat folosind cookie-urile, nu vei putea lăsa comentarii.
</p>
<p>
Toate browserele moderne oferă posibilitatea de a schimba setările cookie-urilor.De regulă, aceste setări se găsesc, în "opțiuni" sau în meniul de "preferințe" al browserului tău.
</p>
        </div>
    </div>
</section>
<?php 
require_once './layout/footer.php';
?>