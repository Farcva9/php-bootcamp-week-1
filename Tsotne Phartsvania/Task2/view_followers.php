<?php 
    session_start();
    if(isset($_SESSION['name'])){
        if($_SESSION['followers'] > 0){
            include "_function.php";
            $url_followers = "https://api.github.com/users/{$_SESSION['name']}/followers?per_page={$_GET['per_page']}&page={$_GET['page']}";
            $response = getAPIDate($url_followers,$_SESSION['name']);
            
            $n=1;
            $followers = $_SESSION['followers'];
            while($followers > 10 ) { 
                $followers -= 10;
                $n++;
            } 
        }
        else{
            header('Location: home.php?warning=Sorry, Not Found Follower');
        } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="<?= '/home.php' ?>" class="btn btn-info">Back</a>
                        <h1 class="d-flex justify-content-center"><?= $_SESSION['name']."'s  Followers"  ?></h1>
                    </div>
                    <div class="card-body">
                        <?php if(!isset($response['message'])): ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Photo</th>
                                        <th scope="col">User Name</th>
                                        <th scope="col">Github Link</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $id = 0; 
                                        foreach ($response as $follower):
                                        $id++         
                                    ?>
                                        <tr>
                                            <td>
                                                <?= $id ?>
                                            </td>
                                            <td>
                                                <img src="<?= $follower['avatar_url']  ?>" style="width:100px;" alt="User" class="img-fluid img-thumbnail rounded-circle border-0 mb-3">
                                            </td>
                                            <td>
                                                <h5 class=""><?= $follower['login'] ?></h5>
                                            </td>
                                            <td>
                                                <a href="<?= $follower['html_url']?>" target="_blank" class="btn btn-danger">Link</a>
                                            </td>
                                        </tr>
                                    <?php 
                                        endforeach 
                                    ?>
                                </tbody>
                            </table>
                            <ul class="pagination">
                                <?php 
                                        $i = 1;
                                        while($i <= $n ):                 
                                ?>
                                    <li class="page-item"><a class="page-link" href=<?= "{$_SERVER['PHP_SELF']}?per_page=10&page=$i" ?>><?php echo $i++ ?></a></li>
                                <?php   
                                    endwhile 
                                ?>
                            </ul>
                        <?php else :?>
                            <?= "<h1>{$decode_user['message']}</h1>"; ?>
                        <?php endif ?> 
                    </div>
                </div>
            </div>
        </div>
    </div>   
</body>
</html>

<?php 
        } else {
            header('Location: index.php?error=თქვენ არ გაგივლიათ ავტორიზაცია');
        }
?>