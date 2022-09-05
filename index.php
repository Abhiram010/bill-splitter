 <!-- Todo
 1. Rewrite the uexists function https://www.youtube.com/watch?v=gCo6JqGMi30 👨‍💻
 2. Complete the login and session functions 👨‍💻
 3. Create a database tables :
 groups -> group_id, group_name,group_creator 👨‍💻
 groupusers -> group_id, user_id 👨‍💻
 Added new group 👨‍💻
 Add members 👨‍💻
 Spilt money👨‍💻
  split is used to manage the group info 👨‍💻
  payments.
 Input to Add
 Add notes
Admin submit to make payments
Show payments and groups joined [move the groups to the dashboard which is in the spilt bill]

if current paid is less than 0 admin can pay back amount
 -->

 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="css/style.css">
     <!-- aos -->
     <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
     <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
     <title>Bill spillter</title>
 </head>

 <body>
     <style>
         .introText p {
             text-align: justify !important;
             font-size: 1rem !important;
         }
     </style>
     <?php
        include "includes/navbar.php";
        ?>
     <main class="content">
         <div class="flex intro">
             <div class="imgContainter">
                 <img src="./images/logo.png" class="logoIntro" alt="">
                 <div id="geo-globe">
                     <canvas id="canvas"></canvas>
                 </div>
             </div>
             <div class="brandIntro">
                 <h1><span class="green">Bill</span>spiltter</h1>
                 <h2 class="gradient-text">Helping customer to manage Bill spilting
                     <br> All Over THE WORLD!
                 </h2>
                 <p>Revolutionary Payment spilt platform...</p>
             </div>
         </div>
         <h1 class="text-center">How <span class="green">Bill</span> spillter work?</h1>
         <div class="flex introContainer">
             <img src="./images/login.svg" alt="" class="introImg" data-aos="zoom-in-down">
             <div class="introText" data-aos="zoom-in-left">
                 <h1>Create user account</h1>
                 <p>Create user account and Login to your dashboard to pay bills and split bills amoung your groups
                     and
                     complete payment within our app!
                     We are secured and two factor authencation is done using pass key and other security measures.
                 </p>
             </div>
         </div>
         <div class="flex introContainer">
             <img src="./images/bill.svg" alt="" class="introImg" data-aos="zoom-in-down">
             <div class="introText" data-aos="zoom-in-left">
                 <h1>Join the Group.</h1>
                 <p>Create a group and get partipants and create bill amount and split the bill with the room
                     members. We
                     had secure payment system and login system and bill amount is shared equally to everyone in the
                     group.</p>
             </div>
         </div>
         <div class="flex introContainer">
             <img src="./images/payment.svg" alt="" class="introImg" data-aos="zoom-in-down">
             <div class="introText" data-aos="zoom-in-left">
                 <h1>Pay your bills</h1>
                 <p>Use our inbuilt payment and pay all your in our platform and have better payment experince and
                     save
                     all your bills at one place and Add your cards and pay all bills without using other services.
                     We
                     had secure partners and all transactions are encrypted and your data was secured stored in our
                     Servers</p>
             </div>
         </div>
         <div class="flex introContainer">
             <img src="./images/reciept.svg" alt="" class="introImg" data-aos="zoom-in-down">
             <div class="introText" data-aos="zoom-in-left">
                 <h1>All your payments are saved.</h1>
                 <p>You can view your all payments which are done in our platform and you can manage all the
                     transactions
                     and bills using our dashboard. And You can get complete info of every transaction done in our
                     platform.</p>
             </div>
         </div>
         <div class="flex introContainer">
             <img src="./images/rewards-1.svg" alt="" class="introImg" data-aos="zoom-in-down">
             <div class="introText" data-aos="zoom-in-left">
                 <h1>Get exculsive rewards</h1>
                 <p>You will be rewarded everytime you use our platfrom to split and pay. We rewards upto 5% cashback
                     on
                     evry payment done and We partned with brands to get deals of them too.
                 </p>
             </div>
         </div>
     </main>
     <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.0/TweenMax.min.js"></script>
     <script src="./js/dots.js"></script>
     <script>
         AOS.init();
     </script>
 </body>

 </html>