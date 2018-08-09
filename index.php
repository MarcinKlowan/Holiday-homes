<?php  
 declare(strict_types=1);

 use Marcin\Form\ReservationForm; //pokazuje ścieżkę do pliku. Musi być zawsze użyte jeżeli są namespace
 use Marcin\Entity\Reservation;

 require __DIR__ . '/vendor/autoload.php';

 $form = new ReservationForm($_POST);
 if($_SERVER['REQUEST_METHOD'] == 'POST');
 {
   if($form->isValid()) { //wywołanie walidacji 
    
      //$dane = new Reservation($_POST['name'], $_POST['surname'], …);
      $reservation = Reservation::createFromPost($_POST);
      //dump($reservation->jsonSerialize()); //serializacja danych z reservation. Można to zrobić również tak jak powytżej $dane i wysłanie do JSON.

      $dateForm = json_encode($reservation);
      // $previousData = file_get_contents("./data/data.json");
      // file_put_contents("./data/data.json", $previousData . ',' . PHP_EOL . $dateForm);
     
      
      if ((file_exists('./data/data.csv') && filesize("./data/data.csv")===0) || !file_exists('./data/data.csv'))
      {
         file_put_contents("./data/data.csv",'Imię;Nazwisko;Liczba;Liczba;Liczba' . PHP_EOL);
      }

      $dateForm = implode(';', $reservation->jsonSerialize());
      file_put_contents("./data/data.csv", $dateForm . PHP_EOL, FILE_APPEND);


      // $daneJson = '{}';
      // $reservation = Reservation::createFromPost(json_decode($daneJson));
          
   } else {
      $myJson = json_encode($form->getErrors()); //kodowanie do json

      http_response_code(400); //ustawienie błędu jaki ma się wyświetlić. Dla każdej akcji ma być/czynności/sprawdzenia ma być tworzony nowy kod sprawdzania
      header('Content-Type: application/json'); //wysyłanie danych w JSON
      
      echo json_encode($myJson); //wyświetla dane w jason
   }
  
 } //sprawdza jaka metoda została użyta do wysłania danych z formularza (POST czy GET) fulfillment?



 




//dump oznacza pobieranie danych z formularza 
//  dump($_POST['name']);
//  dump($_POST['surname']);
//  dump($_POST['numberofhouse']);
//  dump($_POST['numberofpersons']);
//  dump($_POST['numberofchildren']);

//  echo htmlspecialchars($_POST["sentence"]) , PHP_EOL; 

   // $dataForm = new FormWakacje(''); 
  //  $dataForm->setSentence($_POST["post"]);
//  $dataForm->showSentence();

// $name = $_GET["name"];
// $surname = $_POST["surname"];
// $selectNumberOfHouse = $_POST["formdata"];
// $numberOfPersons = $_POST["formdata"];
// $numberOfChildren = $_POST["formdata"];
// dump($name);

// if (isset($_POST['send'])) {
//         if (empty($name) || strlen($name)<=2) { 
//                 echo "Please enter your name. It must contain at least two letters<br />";

// }elseif (empty($surname) || strlen($surname)<=2) { 
//                 echo "Please enter your surname. It must contain at least two letters<br />";

// }elseif (empty($selectNumberOfHouse) || strlen($selectNumberOfHouse)<0) { 
//     echo "Please choose Number of House<br />";

// }elseif (empty($selectNumberOfPersons) || strlen($selectNumberOfPersons)<0) { 
//     echo "Please choose Number of Persons<br />";

// }elseif (empty($selectNumberOfChildren) || strlen($selectNumberOfChildren)<0) { 
//     echo "Please choose Number of Children<br />";

// }else {
//         echo "Twoja wiadomosc zostala wyslana do autora strony. Dziekuje!";
//         $header = "From: " . $nick . " <" . $email . ">\r\nContent-Type: text/plain; charset=\"ISO-8859-2\";";
//         @mail("dawid-bugaj@wp.pl","Wiadomosc z formularza WWW: $temat","$tresc","$header") or die('Nie udalo sie wyslac wiadomosci!');
//     }
// }

