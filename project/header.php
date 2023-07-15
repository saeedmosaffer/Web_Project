<!-- 
<header>
    <img src="photos\world_cup.jpg" alt="logo">
    <strong>Birzeit Sports</strong>
    <form method="POST" style="display: inline;">
        <button type="submit" name="logout">Logout</button>
    </form>
    <a href="aboutus.html">About Us</a>
    <?php if(isset($photo) && !empty($photo)): ?>
        <img src="<?php echo $photo; ?>" alt="profile photo" id="profilephoto">
    <?php endif; ?>
    <b><?php echo $_SESSION['username']; ?></b>
</header>
-->
<header>
<div id="user-profile" style="display: flex; align-items: center;">
        <img src="photos/world_cup.jpg" alt="logo" >
        <Strong style="margin-left: 10px;">Birzeit Sports</Strong>
        </div>
    <form method="POST" style="display: inline;">
        <button type="submit" name="logout">Logout</button>
    </form>
    <a href="aboutus.html">About Us</a>
    <div id="user-profile" style="display: flex; align-items: center;">
        <img src="photos\MyPhoto.jpeg" alt="MyPhoto" id="MyPhoto" style="margin-right: 10px;">
        <b style="margin-left: 10px;"><?php echo $_SESSION['username']; ?></b>
    </div>



</header>


