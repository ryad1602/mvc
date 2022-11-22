<?php 
	//extraction //injection des données dans la base
class Modele{
	private $unPDO; //instance de la classe PDO
	private $table ; //la table sur laquelle s'execute les requetes


public function __construct($serveur, $bdd, $user, $mdp)
{
	$this->unPDO = null;
	try{
	$this->unPDO = new PDO("mysql:host=".$serveur.";dbname=".$bdd, $user, $mdp); //PHP DATA Object
	}
		
		catch(PDOexception $exp){
			echo "Erreur de connexion à la BDD <br/>";
			echo $exp->getMessage();
		}
		
}

/******************************** Get et Set sur la table *******************/
public function getTable(){
	return $this->table;
}
public function setTable($uneTable){
	$this->table = $uneTable;
}

/************** Classes ****************/


public function selectAll()
{
	if($this->unPDO != null){
		//exécuter la requete de selection 
		$requete = "select * from " .$this->table . " ; ";
		//preparation de la requete
		$select= $this->unPDO->prepare($requete);
		//execution de la requete
		$select->execute();
		//extraction des résultats
		$lesResultats = $select->fetchAll();	
		return $lesResultats;
	}
	else
		return null;
}
	public function insert($tab)
	{
		if($this->unPDO != null){
			$tabChamps = array();
			$donnees = array();
			foreach ($tab as $key => $value) {
				$tabChamps[] = ":".$key;
				$donnees[":".$key] = $value;
			}
			$chaineChamps = implode(",", $tabChamps);
			$requete="insert into " .$this->table." values(null,".$chaineChamps.");";
			
			$insert = $this->unPDO->prepare($requete);
			$insert->execute($donnees);
		}
	}
	public function selectLike($mot, $tab)
	{
		$tabChamps = array ();
		foreach ($tab as $value) {
			$tabChamps[] = $value ." like :mot ";
		}
		$chaineChamps = implode(" or ", $tabChamps);
		if($this->unPDO != null){
			$requete = "select * from ".$this->table." where ".$chaineChamps." ;"	;
			$donnees = array(":mot"=>"%".$mot."%");
			$select = $this->unPDO->prepare($requete);
			$select->execute($donnees);
			$lesClasses = $select->fetchAll();
			return $lesClasses;
		}else{
			return null;
		}
	}

		public function delete($id, $value)
		{
			if($this->unPDO != null){
				$requete="delete from ".$this->table." where ".$id." = :".$id.";";
				$donnees = array(":".$id=>$value);
				$delete = $this->unPDO->prepare($requete);
				$delete->execute($donnees);
			}
		}

		public function update($tab, $id, $valueid)
		{
			if($this->unPDO != null){
				$tabChamps = array();
			$donne = array();
			foreach ($tab as $key => $value) {
				$tabChamps[] = $key."=:".$key;
				$donnees[":".$key] = $value;
			}
			$chaineChamps = implode(",", $tabChamps);

				$requete = "update ".$this->table." set ".$chaineChamps." where ".$id." = :".$id." ;";
				$donnees[":".$id] = $valueid;
				$update=$this->unPDO->prepare($requete);
				$update->execute($donnees);
		}
		}
		public function selectWhere($id, $value){
			if($this->unPDO != null){
				$requete="select * from ".$this->table." where ".$id." = :".$id." ;";
				$donnees=array(":".$id=>$value);
				$select= $this->unPDO->prepare($requete);
				$select->execute($donnees);
				$unResultat = $select->fetch();	//un seul resultat
				return $unResultat;
		}else{
			return null;
		}
	}


		public function count()
        {
            if($this->unPDO != null){
                $requete="select count(*) as nb from ".$this->table.";";
                $select= $this->unPDO->prepare($requete);
                $select->execute();
                $unResultat = $select->fetch();
                return $unResultat;
            }else{
                return null;    
            }
        }




        public function verifConnexion($email, $mdp)
        {
            if($this->unPDO != null){
                $requete="select * from user where email ='".$email."' and mdp='".$mdp."' ;";
                
                $select =$this->unPDO->prepare($requete);
                $select->execute();
                $unUser = $select->fetch(); //extraire un résultat
                return $unUser;                
            }else{
                return null;
            }
        }



       public function verifConnexion2($email, $mdp)
        {
            //utilisation du BindValue
            if($this->unPDO != null){
                $requete="select * from user where email =:email and mdp=:mdp;";
                
                $select =$this->unPDO->prepare($requete);
                $select->BindValue(":email", $email, PDO::PARAM_STR);
                $select->BindValue(":mdp", $mdp, PDO::PARAM_STR);
                $select->execute();
                $unUser = $select->fetch(); //extraire un résultat
                return $unUser;                
            }else{
                return null;
            }
        }



       public function verifConnexion3($email, $mdp)
        {
            //utilisation du ?
            if($this->unPDO != null){
                $requete="select * from user where email = ? and mdp= ? ;";
                
                $select =$this->unPDO->prepare($requete);
                $select->BindValue(1, $email, PDO::PARAM_STR);
                $select->BindValue(2, $mdp, PDO::PARAM_STR);
                $select->execute();
                $unUser = $select->fetch(); //extraire un résultat
                return $unUser;                
            }else{
                return null;
            }
        }




        public function verifConnexion4($email, $mdp)
        {
            //utilisation d'un array de données
            if($this->unPDO != null){
                $requete="select * from user where email =:email and mdp=:mdp ;";
                $donnees = array(":email"=>$email, ":mdp"=>$mdp);
                $select =$this->unPDO->prepare($requete);
                $select->execute($donnees);
                $unUser = $select->fetch(); //extraire un résultat
                return $unUser;                
            }else{
                return null;
            }
        }




        
}
?>