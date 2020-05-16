<html>
    <head>
        
    </head>
    <body>
        <form name= "forma" method ="POST" action="<?= site_url("../Korisnik/test") ?>">
            
            <input id = 'dugme' type="submit" value="probaj"  />
            <input type = 'text' name = 'tekst' placeholder="popuni" />
            <input type="file" id="avatar" name="avatar" accept="image/png, image/jpeg">
        </form>
    
    </body>

</html>
