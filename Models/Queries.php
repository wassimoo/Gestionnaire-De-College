<?php
    class Queries
    {
        /**
         * @param $dbh PDO with connection established
         * @param $query string query string with no data to be prepared
         * @param $data array  data to perform query with
         * @return array returned by fechAll() containing all result rows
         */
        public static function performQuery($dbh,$query,$data){
            $stmt = $dbh->prepare($query);
            if($data != NULL)
                $stmt->execute($data);
            else
                $stmt->execute();

            return $stmt->fetchAll();
        }
    }