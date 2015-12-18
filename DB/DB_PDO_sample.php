<?php
$dsn = 'pgsql:dbname=dbname_1 host=db.host.com port=5432';
$user = 'postgres_user';
$password = 'db_passsword';

try{
	$dbh = new PDO($dsn, $user, $password);

	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query =<<<__QUERY__
 SELECT :test ;

__QUERY__;

        $stmt = $dbh->prepare($query,array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

        $array = array(':test'=>' aaaa ');
        $stmt->execute($array);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

}catch (PDOException $e){
	print $query;
	print('Error:'.$e->getMessage());
	die();
} catch (Exception $e) {
	print('Error:'.$e->getMessage());
	die();
}
