<?php
$category = "math";
echo "category: {$_SESSION['category']}";
function openConnection(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "numfacts";
    $conn = new mysqli($servername, $username, $password,$dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }else{
        return $conn;
    }
}
function setHistory($facts){
    $conn = openConnection();
    $sql = "INSERT INTO history(facts) VALUES ('{$facts}')";
    if ($conn->query($sql)) {
        // echo "New record created successfully";
    } 
    else {
    // echo "Iror";
    }
}

function getData($number){
    $url = "http://numbersapi.com/$number";
    $response = file_get_contents($url);
    if($response !== false){
        return $response;
    }else{
    }
}
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['number'])){
    $result = getData($_POST['number']);
    setHistory($result);
    // header('Location: '.$_SERVER["PHP_SELF"], true, 303);
}
?>
<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="Dark.css" />
    <title>Final</title>
  </head>
  <body style="background-color: rgb(37, 37, 37)">
    <header class="header">
      <p
        class="num"
        style="color: blueviolet; font-family: Montserrat; font-weight: bold"
      >
        Num.
      </p>

      <nav class="nav-bar">
        <ul class="buttons">
          <li class="nav-item"><a href=""> Home </a></li>
          <li class="nav-item"><a href=""> History </a></li>
          <li class="nav-item"><a href=""> Account </a></li>
        </ul>
      </nav>
      <div class="hamburger">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
      </div>
    </header>
    <hr class="nav-line" />
    <div class="categories">
      <div class="category math" id="math" name="math" onclick="selectCategory('math')" value="math">Math</div>
      <div class="category trivia" id="trivia" name="trivia" onclick="selectCategory('trivia')"value="trivia">Trivia</div>
      <div class="category date" id="date" name="date" onclick="selectCategory('date')"value="date">Date</div>
    </div>
    <form action="" method="post" onsubmit="validateForm(event)">
      <div class="input-container">
        <input
          class="userBox"
          type="number"
          id="userBox"
          name="number"
          value=""
          placeholder="Enter a number"
        />
        <input class="submit" type="submit" value="Submit" />
      </div>
    </form>
    <?php if (isset($result)) { ?>
    <div class="output"><?php echo $result ?></div>
    <?php } ?>
    <div class="history">
      <hr class="history-line" />
      <p class="history-title" style="color: white">History</p>
      <?php
        $conn = openConnection();
        $sql = "SELECT id, facts, created_at FROM history ORDER BY created_at DESC";
        $history = $conn->query($sql);
        if ($history->num_rows > 0) {
            while($row = $history->fetch_assoc()) {
                echo "<p class=\"history-data\" style=\"color: white\">{$row['facts']}</p>";           
            }
        }else{
        }
        ?>
      
    </div>
  </body>
  <script type = "text/javascript">
    const hamburger = document.querySelector(".hamburger");
    const navMenu = document.querySelector(".nav-bar");

    hamburger.addEventListener("click", mobileMenu);

    function mobileMenu() {
      hamburger.classList.toggle("active");
      navMenu.classList.toggle("active");
    }
    function validateForm(event) {
            var input = document.getElementById("userBox");
            if (input.value.trim() === "") {
                event.preventDefault(); // Prevent form submission
                alert("Please input a number.");
            }
        }
    function selectCategory(id){
        var value = document.getElementById(id).id;
        console.log(value);
    }
    // const navLink = document.querySelectorAll(".nav-link");

    // navLink.forEach((n) => n.addEventListener("click", closeMenu));

    // function closeMenu() {
    //   hamburger.classList.remove("active");
    //   navMenu.classList.remove("active");
    // }
    
  </script>
</html>
