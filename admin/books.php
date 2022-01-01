<?php


$connection = mysqli_connect("localhost","root","","libdb");
include('security1.php');
include('includes/header.php'); 
include('includes/navbar.php'); 
?>


<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">REGISTER NEW BOOK</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="code.php" method="POST" enctype="multipart/form-data">

        <div class="modal-body">
          
        <div class="form-group">
                <label>Book Title </label>
                <input type="text" name="title" required class="form-control" placeholder="">
            </div>
            <?php
            $books = "SELECT * FROM category";
            $books_run = mysqli_query($connection, $books);
          
           if(mysqli_num_rows($books_run) > 0)
          {
            
            ?>
            
            <div class="form-group">
                <label>category</label>
                 <select name="category" class="form-control" required>
                      <option value=""> please choose a category</option>
                      <?php
                      foreach($books_run as $row)
                      {
                      ?>
                     <option value="<?php echo $row['name']?>"><?php echo $row['name']?></option>
                        <?php
                          }
                        ?>
                    </select>


          
          <?php


          }
          else
          {
            echo  "<h5>add the author </h5>";?>
            <a href="autorsssss.php" class="btn btn-outline-primary">CANCEL</a>
            <?php
          }

            ?>  

                      

            
            
            <?php
            $authors = "SELECT * FROM autors";
            $author_run = mysqli_query($connection, $authors);
            if(mysqli_num_rows($author_run) > 0)
            {
              ?>
              
            <div class="form-group">
                <label>Authors</label>
                 <select name="autor" id="" class="form-control" required> 
                      <option value=""> please choose the Authors</option>
                      <?php
                      foreach($author_run as $row)
                       {
                         ?>
                      <option value="<?php echo $row['name']?>"> <?php echo $row['name']?></option>
                      <?php
                       }
                      ?>
                </select>
            </div>
                  

                  
                
                <?php

               }

            
            else
            {
              echo  "<h5>add the author </h5>";?>
              <a href="autor.php" class="btn btn-outline-primary">CANCEL</a>
              <?php
            }
              
            ?>


            </div>
            <div class="form-group">
                <label>Edition</label>
                <input type="text" name="edition" required class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <input type="hidden" name="value" required class="form-control"  VALUE="0" placeholder="">
            </div>
            
            <div class="form-group">
                <label> Uploud Image </label>
                <input type="file" name="bookimages" required class="form-control">
            </div>
        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="registerbook" class="btn btn-primary">Save</button>
        </div>
      </form>

    </div>
  </div>
</div>


<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Books section
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
              Add New Book 
            </button>
            
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"  >
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" name="searchbook" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary"name="searchbook" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>
    </h6>
  </div>

  <div class="card-body">
    
    
          
  <?php
 
          if(isset($_SESSION['success']) && $_SESSION['success'] !='')
          {
            echo '<h2  class = "bg-primary  text-white">'.$_SESSION['success'].'</h2>';
            unset($_SESSION['success']);
           }
            if(isset($_SESSION['status']) && $_SESSION['status'] !='')
            {
              echo '<h2  class = "bg-danger  text-white">'.$_SESSION['status'].'</h2>';
              unset($_SESSION['status']);
              }
        ?>

    <div class="table-responsive">
      
    <?php
     
     $connection = mysqli_connect("localhost", "root", "", "libdb");
     $query = "SELECT * FROM log ";
     $query_run = mysqli_query($connection, $query);
     ?>

      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          
     <div class="text-center">
       <button onclick="window.print(dataTable)" class="btn btn-primary"> print </button>
    
          <tr>
            <th>user </th>
            <th> password</th>
            <th>EDIT </th>
            <th>DELETE </th>
            
          </tr>
        </thead>
        <tbody>
        <?php
          if(mysqli_num_rows($query_run) > 0)
          {
            while($row = mysqli_fetch_assoc($query_run))
            {
              ?>

     
          <tr>
          <td>  <?php   echo $row["id"]; ?> </td>
            <td>  <?php   echo $row["user"]; ?> </td>
            <td>  <?php   echo $row["password"]; ?></td>
            <td>
                <form action="books_edit.php" method="post">
                    <input type="hidden" name="book_id" value="  <?php   echo $row["id"]; ?>">
                    <button  type="submit" name="edit_book" class="btn btn-success"> EDIT</button>
                </form>
            </td>
            <td>
                <form action="code.php" method="post">
                  <input type="hidden" name="delete_id" value="<?php   echo $row["id"]; ?> ">
                  <button type="submit" name="delete_book" class="btn btn-danger"> DELETE</button>
                </form>
            </td>
          </tr>
          
          <?php
              
            }

          }
          
          else {
            echo "No Record Found";
          }
          ?>
           </div>
        
        </tbody>
      </table>

    </div>
  </div>
</div>

</div>
<!-- /.container-fluid -->

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>