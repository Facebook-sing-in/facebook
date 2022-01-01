<?php
//admin reg

session_start();

$connection = mysqli_connect("localhost","root","","libdb");
#include('security.php');

if(isset($_POST['registerbtn']))
{
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['confirmpassword'];
    $image = $_FILES['regimages']['name'];

    $store =$_FILES["regimages"]["name"];

    if($password === $cpassword)
    {
        $query = "INSERT INTO register (username, email, password,image) VALUES ('$username', '$email','$password','$image')";
         $query_run = mysqli_query($connection, $query);

         if($query_run)
         {
             // data saved
             move_uploaded_file($_FILES["regimages"]["tmp_name"], "upload/".$_FILES["regimages"]["name"]);
              $_SESSION['success'] = " ADMIN PROFILE ADDED";
             header('Location: register.php');
         }
     
         else
         {
         
         $_SESSION['status'] = "ADMIN PROFILE IS NOT ADDED";
         header('Location: register.php');
          }
        }
     else
     {
         
         $_SESSION['status'] = "password AND CONFIRM PASSWORD DAES not same";
        header('Location: register.php');
    }

    
}  
//reg update

if(isset($_POST['updatereg']))
{
    $id = $_POST['edit_id'];
    $username = $_POST['edit_username'];
    $email = $_POST['edit_email'];
    $password = $_POST['edit_password'];
    $images = $_FILES['regimages']['name'];
    $query= "UPDATE register SET username='$username', email='$email',password='$password', image='$images' WHERE id='$id'";
    $query_run =mysqli_query($connection, $query);

    if($query_run)
    {
        move_uploaded_file($_FILES["regimages"]["tmp_name"], "upload/".$_FILES["regimages"]["name"]);
        $_SESSION['success'] = "Your date is updated";
     
    }
    else
    {
        $_SESSION['status'] = "Your date is not updated";
        header('location: register.php');
    }
}


//reg delete


if(isset($_POST['delete_reg']))
{
    $id = $_POST['deleted_id'];
    $query = "DELETE FROM register WHERE id='$id'";
    $query_run =mysqli_query($connection, $query);
    
    if($query_run)
    {
        $_SESSION['success'] = "DELETED SUCCESSFULLY";
        header('location: register.php');

    }
    else
    {
        $_SESSION['status'] = "YOUR DATA IS NOT DELETED";
        header('location: register.php');
    }
}


//books reg

if(isset($_POST['registerbook']))
{
     $title = $_POST['title'];
    $autor = $_POST['autor'];
    
    $category = $_POST['category'];
    $edition = $_POST['edition'];
     $image = $_FILES['bookimages']['name'];
     $values = $_POST['value'];

         $store =$_FILES["bookimages"]["name"];
        

         $query = "INSERT INTO book_database ( title, autor,edition,category,image,value) VALUES ( '$title','$autor','$edition','$category','$image','$values')";
          $query_run = mysqli_query($connection, $query);

          if($query_run)
          {
                       
             // data saved
             move_uploaded_file($_FILES["bookimages"]["tmp_name"], "upload/".$_FILES["bookimages"]["name"]);
             $_SESSION['success'] = " NEW BOOK ADDED";
              header('Location: books.php');
          }
     
          else
          {
         
          $_SESSION['status'] = "THIS BOOK IS NOT ADDED";
          header('Location: books.php');
           }
    
}  


//book edit


if(isset($_POST['updatebook']))
{
    $id = $_POST['edit_id'];
    $title = $_POST['edit_title'];
    $autor = $_POST['edit_autor'];
    $category = $_POST['edit_category'];
    $edition = $_POST['edit_edition'];
    $images = $_FILES['regimages']['name'];

    $facult_query ="SELECT * FROM book_database  WHERE id ='$id'";
    $facult_query_run = mysqli_query($connection, $facult_query);
    foreach($facult_query_run as $fa_row)
    {
       if($images == NULL)
       {
        $image_data = $fa_row['image'];
        
       }
       else
       {
           if($img_path = "upload/".$fa_row['image'])
           {
               unlink($immg_path);
               $image_data = $images;
           }
        }
    }

    

   
          
    $query= "UPDATE book_database SET title='$title', autor='$autor',category='$category', edition='$edition', image='$image_data' WHERE id='$id'";
    $query_run =mysqli_query($connection, $query);

    if($query_run)
    {
        if($images == NULL)
       {    
            $_SESSION['success'] = "Your data is updated with existing image";
            header('location: books.php');
       }
       else{
                move_uploaded_file($_FILES["bookimages"]["tmp_name"], "upload/".$_FILES["bookimages"]["name"]);
            
                $_SESSION['success'] = "Your data is updated";
                header('location: books.php');
           }
    }
        
    
    else
    {
        $_SESSION['success'] = "Your date is not updated";
        header('location: books.php');
    }

}

    // return books




    if(isset($_POST['returnids']))
    {
        $retenid= $_POST['ret_id'];
        $id = $_POST['return_id'];
        $value= $_POST['values'];
         
        $query= "UPDATE book_database SET value='$value' WHERE id='$id'";
        $query_run =mysqli_query($connection, $query);
        
        if($query_run)
       {    
        $query= "UPDATE issued SET available='$value' WHERE id='$retenid'";
        $query_run =mysqli_query($connection, $query);
        
        
            $_SESSION['success'] = "Returned a Book";
            header('location: not_return.php');
       }
       else{
            
                $_SESSION['success'] = "Your data is updated";
                header('location: not_return.php');
           }
    }





//book delete



if(isset($_POST['delete_book']))
{
    $id = $_POST['delete_id'];
    $query2 = "DELETE FROM log WHERE id='$id'";
    $query_run =mysqli_query($connection, $query2);
    
    if($query_run)

    {
        
    $query1 = "DELETE FROM book_database WHERE id='$id'" ;
    
    $query_run =mysqli_query($connection, $query1);
        $_SESSION['success'] = "DELETED SUCCESSFULLY";
        header('location: books.php');

    }
    else
    {
        $_SESSION['status'] = "THIS BOOK CAN'T BE DELETED, BICOUSE IT'S ISSSUED";
        header('location: books.php');
    }
}


// issued books



if(isset($_POST['registerissued']))
{
    $member = $_POST['memberid'];
    $book = $_POST['booksirno'];
    
    $issueddate = $_POST['issueddate'];
    $returndate = $_POST['returndate'];
    $availabale = $_POST['availabale'];



    $query = "INSERT INTO issued ( member_id, book_sNo,	isued_date,return_date,	available) VALUES ( '$member','$book','$issueddate','$returndate','$availabale')";
    $query_run = mysqli_query($connection, $query);
          if($query_run)
          {
              
                $query1= "UPDATE book_database SET value='1', frequency= frequency+'1' WHERE id='$book'";
                
                $query_run =mysqli_query($connection, $query1);       
             // data saved
             $_SESSION['success'] = " ADDED SECCESSFULLY";
              header('Location: issued_books.php');
          }
     
          else
          {
         
          $_SESSION['status'] = "THIS DATA IS NOT ADDED";
          header('Location: issued_books.php');
           }

}  













//category reg



if(isset($_POST['registercat']))
{
    $name = $_POST['name'];

        $query = "INSERT INTO category (name) VALUES ('$name')";
         $query_run = mysqli_query($connection, $query);

         if($query_run)
         {
             // data saved
              $_SESSION['success'] = "NEW CATECORY ADDED";
             header('Location: category.php');
         }
     
         else
         {
         
         $_SESSION['status'] = "THIS DATA IS NOT NOT ADDED";
         header('Location: category.php');
          }

    
}  

//category edit
if(isset($_POST['updatecat']))
{
    $id = $_POST['edit_id'];
    $name = $_POST['edit_name'];
    $query= "UPDATE category SET name='$name' WHERE id='$id'";
    $query_run =mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['success'] = "Your date is updated";
        header('location: category.php');

    }
    else
    {
        $_SESSION['success'] = "Your date is not updated";
        header('location: category.php');
    }
}

//category delete


if(isset($_POST['delete_cat']))
{
    $id = $_POST['delete_id'];
    $query = "DELETE FROM category WHERE id='$id'";
    $query_run =mysqli_query($connection, $query);
    
    if($query_run)
    {
        $_SESSION['success'] = "DELETED SUCCESSFULLY";
        header('location: category.php');

    }
    else
    {
        $_SESSION['status'] = "YOUR DATA WAS NOT DELETED";
        header('location: category.php');
    }
}


//autor reg



if(isset($_POST['registeraut']))
{
    $name = $_POST['name'];

        $query = "INSERT INTO autors (name) VALUES ('$name')";
         $query_run = mysqli_query($connection, $query);

         if($query_run)
         {
             // data saved
              $_SESSION['success'] = " ADMIN PROFILE ADDED";
             header('Location: autor.php');
         }
     
         else
         {
         
         $_SESSION['status'] = "ADMIN PROFILE IS NOT ADDED";
         header('Location: autor.php');
          }

    
}  
//autor edit


if(isset($_POST['updateaut']))
{
    $id = $_POST['edit_id'];
    $name = $_POST['edit_name'];
    $query= "UPDATE autors SET name='$name' WHERE id='$id'";
    $query_run =mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['success'] = "Your date is updated";
        header('location: autor.php');

    }
    else
    {
        $_SESSION['success'] = "Your date is not updated";
        header('location: autor.php');
    }
}

//delete autor
if(isset($_POST['delete_aut']))
{
    $id = $_POST['delete_id'];
    $query = "DELETE FROM autors WHERE id='$id'";
    $query_run =mysqli_query($connection, $query);
    
    if($query_run)
    {
        $_SESSION['success'] = "DELETED SUCCESSFULLY";
        header('location: autor.php');

    }
    else
    {
        $_SESSION['status'] = "YOUR DATA WAS NOT DELETED";
        header('location: autor.php');
    }
}






// members


if(isset($_POST['registermem']))
{
    $username = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

        $query = "INSERT INTO members (name, email, phone,address) VALUES ('$username', '$email','$phone','$address')";
         $query_run = mysqli_query($connection, $query);

         if($query_run)
         {
             // data saved
              $_SESSION['success'] = " ADMIN PROFILE ADDED";
             header('Location: members.php');
         }
     
         else
         {
         
         $_SESSION['status'] = "ADMIN PROFILE IS NOT ADDED";
         header('Location: members.php');
          }

}
    

//mem update

if(isset($_POST['updatemem']))
{
    $id = $_POST['edit_id'];
    $name = $_POST['edit_name'];
    $email = $_POST['edit_email'];
    $phone = $_POST['edit_phone'];
    $address = $_POST['edit_Address'];

    $query= "UPDATE members SET name='$name', email='$email', phone='$phone' , address='$address' WHERE id='$id'";
    $query_run =mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['success'] = "Your date is updated";
        header('location: members.php');

    }
    else
    {
        $_SESSION['status'] = "Your date is not updated";
        header('location: members.php');
    }
}


//reg delete 


if(isset($_POST['delete_mem']))
{
    $id = $_POST['deleted_id'];
    $query = "DELETE FROM members WHERE id='$id'";
    $query_run =mysqli_query($connection, $query);
    
    if($query_run)
    {
        $_SESSION['success'] = "DELETED SUCCESSFULLY";
        header('location: members.php');

    }
    else
    {
        $_SESSION['status'] = "THIS MEMBER ISSUED A BOOK, SO CAN'T BE DELETED";
        header('location: members.php');
    }
}








//login



if(isset($_POST['login_btn']))
{
    $email_login = $_POST['emaill'];
    $password_login = $_POST['passwordd'];
    
    $query = "SELECT * FROM register WHERE  email='$email_login' and password='$password_login'";
    $query_run = mysqli_query($connection,$query);
    
    if(mysqli_fetch_array($query_run))
    {
        $_SESSION['username'] = $email_login;
        header('location: index.php');

    }
    else
    {
        $_SESSION['status'] = "Email id or Password is invalid";
        header('location: login.php');
    }
}




//log out











?>