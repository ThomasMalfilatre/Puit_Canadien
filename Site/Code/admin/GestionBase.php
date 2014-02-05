<?php
    include("ConnexionBD.php");

    // renvoie le nom de toute les corbeilles
    function nomCorbeille(){
        global $connexion;
        $result = $connexion->prepare("SELECT Corbeille_id, Nom from Corbeille");
        $result->execute();
        return $result;
    }

    // renvoie le nom de tout les puits
    function nomPuits(){
        global $connexion;
        $result = $connexion->prepare("SELECT Nom_puits from Puits");
        $result->execute();
        return $result;
    }

    // renvoie les infos de toute les sondes 
    function nomSonde(){
        global $connexion;
        $result = $connexion -> prepare("SELECT * from Sonde");
        $result -> execute();
        return $result;
    }

    function AjouterSonde($nom, $niveau){
        global $connexion;
        $result = $connexion -> prepare("INSERT INTO Sonde VALUES (NULL, :nom, :niveau)");
        $result -> bindParam(':nom', $nom);
        $result -> bindParam(':niveau', $niveau);
        $result -> execute();
    }

    // fonction qui renvoie les infos d'une corbeille ou d'un puit en fonction de son nom
    function rechercheNom($nom){
        global $connexion;
        $result = $connexion -> prepare( "SELECT * FROM Corbeille where Nom = :n");
        $result -> bindParam(':n', $nom);
        $result -> execute();
        $data = $result->fetch(PDO::FETCH_ASSOC);
        if($data){
            return $data;
        }
        else{  
            $result = $connexion -> prepare("SELECT * FROM Puits where Nom_puits = :nom");
            $result -> bindParam(':nom', $nom);
            $result -> execute();
            $data = $result->fetch(PDO::FETCH_ASSOC);
            if($data){
                return $data;
            }
        }
        return NULL;
    }

    // fonction qui renvoi l'id d'une sonde a partir de son nom
    function rechercheIdSonde($nom){
        global $connexion;
        $result = $connexion -> prepare("SELECT * FROM Sonde where Nom = :n");
        $result -> bindParam(':n', $nom);
        $result->execute();
        $data = $result->fetch(PDO::FETCH_ASSOC);
        if($data["Sonde_id"]){
            return $data["Sonde_id"];
        }
        else return NULL;
    }

    // associe une sondes a un puit ou une corbeille
    function AjouterDependance($nom_Sonde, $nom_Corbeille){
        global $connexion;
        $data = rechercheNom($nom_Corbeille);
        $id = rechercheIdSonde($nom_Sonde);
        if($data == NULL && $id == NULL){
            exit();
        }
        elseif($data["Corbeille_id"]){
            $req = 'INSERT INTO Appartient_Corbeille VALUES ('.$id.','.$data["Corbeille_id"].')';    
            $result = $connexion -> prepare($req);
            $result -> execute();
        }
        elseif($data["Nom_puits"]){
            $req = 'INSERT INTO Appartient_Puits VALUES ('.$id.',"'.$data["Nom_puits"].'")';
            $result = $connexion -> prepare($req);
            $result -> execute();
        }
    }

    function AjouterPuits($nom){
        global $connexion;
        $result = $connexion -> prepare("INSERT INTO Puits VALUES(:n)");
        $result -> bindParam(':n', $nom);
        $result -> execute();
    }

    function AjouterCorbeille($nom){
        global $connexion;
        $pos = "position";
        $zone = "zone";
        $result = $connexion -> prepare("INSERT INTO Corbeille VALUES(NULL, :nom, :pos ,0,0, :z)");
        $result -> bindParam(':nom', $nom);
        $result -> bindParam(':pos', $pos);
        $result -> bindParam(':z', $zone);
        $result -> execute();
    }

    function suppressionSonde($id){
        global $connexion;
        $req = "DELETE from Sonde where Sonde_id = :id";
        // echo $req;
        $result = $connexion -> prepare($req);
        $result -> bindParam(':id', $id);
        $result -> execute();
    }

    function suppressionPuits($nomPuits){
        global $connexion;
        $result = $connexion -> prepare("DELETE from Puits where Nom_puits = :nom");
        $result -> bindParam(':nom', $nomPuits);
        $result -> execute();
    }

    function suppressionCorbeille($id){
        global $connexion;
        $result = $connexion -> prepare("DELETE from Corbeille where Corbeille_id = :id");
        $result -> bindParam(':id', $id);
        $result -> execute();
    }
?>