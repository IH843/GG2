<?php
include '444.php';
include 'text.php';
include 'tmlol.php';



$AA ="אנא הקלט ובסיום הקש סולמית";
$ID=$_GET['ApiPhone'];
$V=$_GET['ApiCallId'];
$C=$_GET['ApiTime'];

//$ID="0534175145";

 $SS=$_GET['SS'];
 if($SS==null){
 echo "read=t-$AA=SS,,record,/123456/1,$ID,no,,,,100";
 }else{

sleep(2);


// קישור להורדת קובץ שמע
$audio_url = "https://www.call2all.co.il/ym/api/DownloadFile?token=0733181449:411249319&path=ivr2:/123456/1/$ID.wav";

$text=tmlol($audio_url);


     

if($text!="None"){

//שליחת שאלה

$url = "http://localhost:6069/chat"; // שנה לכתובת ה-API שלך
$data = [
    "messages" => [
        ["role" => "system", "content" => "$YY"],
        ["role" => "user", "content" => "$text"]
    ]
];

$jsonData = json_encode($data);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

$response = curl_exec($ch);
curl_close($ch);


$VV= json_decode($response, true);
$NN= $VV['response'];


$regex = "/[\*]/";
$replace =",";
$XX=preg_replace ($regex, $replace, $NN);
$regex = "/[\"]/";
$replace ="'";
$FF=preg_replace ($regex, $replace, $XX);

$regex = "/[^A-Za-zא-ת0-9\,\.[\]\(\) \-]/u";
$replace ="";
$GG=preg_replace($regex,$replace,$FF);

$regex = "/[ ]/";
$replace ='+';
$BB=preg_replace ($regex, $replace, $GG);
$to = "dwd94637@gmail.com";
$subject = "$ID שאל שאלה";
$message =":שיחה רגילה\r\nהשאלה היא\r\n$text\r\nוהתשובה היא:\r\n $GG";
$headers = "From: your-email@example.com\r\n";
mail($to, $subject, $message, $headers);
if(preg_match( '/אני לא עונה לך על שאלות מנושאים כאלו כלל ושיהיה לך יום נעים/',$GG)){
      $dayOfWeek = date('w'); // מחזיר את היום בשבוע (0 - ראשון, 1 - שני, ..., 6 - שבת)

    $waitTime = 0;
    // אם היום יום ראשון (0)
    if ($dayOfWeek == 0) {
        $waitTime = 240368; // המתנה 1 שנייה ביום ראשון
    } else if ($dayOfWeek == 1) {
        $waitTime = 240081; // המתנה 2 שניות ביום שני
    } else if ($dayOfWeek == 2) {
        $waitTime = 240083; // המתנה 3 שניות ביום שלישי
    } else if ($dayOfWeek == 3) {
        $waitTime = 240084; // המתנה 4 שניות ביום רביעי
    } else if ($dayOfWeek == 4) {
        $waitTime = 240087; // המתנה 5 שניות ביום חמישי
    } else if ($dayOfWeek == 5) {
        $waitTime = 240088; // המתנה 6 שניות ביום שישי
    } else if ($dayOfWeek == 6) {
        $waitTime = 240089; // המתנה 7 שניות ביום שבת
    }

//file_get_contents("https://www.call2all.co.il/ym/api/UpdateTemplateEntry?token=0733181449:411249319&templateId=$waitTime&phone=$ID");
echo "id_list_message=t-$GG&go_to_folder=/999&";
}elseif(preg_match( '/אני לא עונה על שאלות מהסוג הזה אשמח לעזור בנושאים שאני חשב שהם מתאימים לרוח התורה והמיצוות הרי אנחנו כולנו יהודים כשרים בי נשמה/',$GG)) {
    
     echo "id_list_message=t-$GG&go_to_folder=/9999&";
}else{
//העלאת הקלטה 
//text($GG,$ID);

file_get_contents("https://www.call2all.co.il/ym/api/UploadTextFile?token=0733181449:411249319&what=ivr2:12345/1/$ID.tts&contents=$BB");
sleep(1);
echo "id_list_message=f-/12345/1/$ID&go_to_folder=/555&";

}
}else {
  $BB="שגיאה לא התקבל תמלול";
   
echo "id_list_message=t- $BB 'הנך מועבר לשאלה מחדש'.g-/9999/1/2";


}

}


?>
