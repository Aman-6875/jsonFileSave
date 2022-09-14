<!DOCTYPE html>
<html>
<body>

    <h2>HTML Forms</h2>

    <form action="/get-json" method="POST" enctype="multipart/form-data">
        @csrf
    <label for="fname">First name:</label><br>
    <input type="file" id="fname" name="file"><br>
    <input type="submit" value="Submit">
    </form> 

<p>If you click the "Submit" button, the form-data will be sent to a page called "/action_page.php".</p>

</body>
</html>