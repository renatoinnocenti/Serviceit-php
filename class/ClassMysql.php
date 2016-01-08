<?php
class MYSQL
{
    var $conexao;
    var $db_name;
    var $sql;
    var $caption=array();
    ######################################################################
    ## INICIA UMA CONECï¿½ï¿½O MYSQL                                        ##
    ## MYSQL($smarty);                                                  ##
    ## $smarty = OBJETO => OBJETO DE CONFIGURAï¿½ï¿½O                       ##
    ######################################################################
    function MYSQL(&$cfg){
        @mysql_close();
        
        $this->conexao = mysql_connect('sql307.byethost7.com','b7_17137024','w2tncmg4');
        mysql_select_db('b7_17137024_wp437',$this->conexao);
        $this->db_name='b7_17137024_wp437';
    }
    
    ######################################################################
    ## RETORNA O RANDLE DA CONECï¿½ï¿½O ATUAL                           ##
    ## Connection();                                                    ##
    ######################################################################
    function Connection(){
    return $this->conexao;
    }
    ####################################################################
    ## METODO FAZ A CONFIGURAï¿½ï¿½O DA LISTAGEM, Nï¿½O EXIBE NADA          ##
    ## CreateSelectSQL($params, &$smarty)                             ##
    ## $params = ARRAY => RECEBE TODOS OS PARAMETROS DA TAG           ##
    ## $smarty = OBJETO => RECEBE O OBJETO DO TEMPLATE                ##
    ##      @settable = string - Nome da tabela a ser acessada        ##
    ##      @setcaption = string/array - Nome das tabelas a serem     ##
    ##          selecionadas.                                         ##
    ##      @setcombine = string/array - Nome das tabelas a serem     ##
    ##          adicinadas na seleï¿½ï¿½o                                 ##
    ##      [OPCIONAIS]                                               ##
    ##      @setdistinct = string - tabela sql que serï¿½ acessada      ##
    ##      @setcombinedirect = LEFT|RIGHT direï¿½ï¿½o da uniï¿½o           ##
    ##      @setcombinecol = String - Tabela a ser comparada          ##
    ##      @setlistadm = string - Tabela com o valor de ID do usuario##
    ##      @setlistadmnivel = String - Nivel de permiï¿½ï¿½o da listagem ##
    ##      @setlistaprovar = int/bolan = tabela com valores de       ##
    ##          linha liberada para listagem                          ##
    ##      @setlistextra = SQL - comando SQL para o WHERE            ##
    ##      @setsearch = string - Palavras a serem buscadas           ##
    ##      @setorder = DESC|ASC - Direï¿½ï¿½o de listagem das buscas     ##
    ##      @setordenar = string/array - Tabela a ser ordenada        ##
    ##      @setstart = int - Numero do registro inicial              ##
    ##      @setmax = int - Numero de resultados a serem buscados     ##
    ####################################################################
    function CreateSelectSQL($params){
        extract($params);
        if(empty($settable)){
            print "Tabela inexistente";
            break;
        }elseif(empty($setcaption)){
            print "Caption inexistente";
            break;
        }elseif(!empty($setcombine) && empty($setcombinecol)){
            print "combinação invalida";
            break;
        }else{
            $this->sql = "SELECT ";
            if(!empty($setdistinct)){
                $this->sql .= "DISTINCT ";
                $this->PREFIX_TABLE = 1;
            }
            if(is_array($setcaption)){
                $this->sql .= implode(", ",$setcaption);
            }else{
                $this->sql .= $setcaption;
            }
            $this->caption = $setcaption;
            $this->sql .= " FROM ";
            if(is_array($settable)){
                $this->sql .= implode(", ",$settable);
            }else{
                $this->sql .= $settable;
            }
            if(!empty($setcombine)){
                if(!empty($setcombinedirect))
                    $setcombinedirect = " LEFT";
                if(is_array($setcombine) && is_array($setcombinecol)){
                    if(count($setcombine) != count($setcombinecol))
                        return "Não encontrou combinação";
                    for($x=0; $x< count($setcombine);$x++){
                        $this->sql .= $setcombinedirect.' JOIN '.$setcombine[$x].' USING ('.$setcombinecol[$x].') ';
                    }
                }else{
                    $this->sql .= $setcombinedirect.' JOIN '.$setcombine.' USING ('.$setcombinecol.')';
                }
            }
            #### Clausulas WHERE
            $where = " WHERE ";
            if(!empty($setlistaprovar)){
            $this->sql .= $where. $setlistaprovar . '= \'1\'';
            $where = " AND ";
            }
                if(!empty($setlistextra)){
                    $this->sql .= $where. $setlistextra;
                    $where = " AND ";
                    }
                    if(!empty($setsearch)){
                    $sql['busca']= htmlentities($setsearch,ENT_QUOTES);
                        $buscas = explode(' ', $sql['busca']);
                        $sq =($where != " WHERE ")?" AND (":" WHERE ";
                        if(is_array($settable)){
                        foreach($settable as $valor){
                            foreach($this->ListaCampos($smarty,$valor) as $v){
                            $sq .= " $v LIKE ";
                                foreach($buscas as $bus){
                                $sq .= "'%".$bus."%' OR ";
                                }
                                }
                                }
                            }else{
                            foreach($this->ListaCampos($smarty,$settable) as $v){
                            $sq .= " $v LIKE ";
                                foreach($buscas as $bus){
                                $sq .= "'%".$bus."%' OR ";
                                }
                                }
    
                            }
                            $sq = substr($sq, 0, -4);
                            $sq .=($where != " WHERE ")?")":"";
                            $this->sql .= $sq;
                    }
                    if(!empty($SetFiltros)){
                        if(is_array($SetFiltros)){
                            $sq =($where != " WHERE ")?" AND (":" WHERE ";
                            foreach($SetFiltros as $chave => $valor){
                                if($valor == '' || $valor == false)continue;
                                $sq .=$chave .' = \''.$valor.'\' AND ';
                        }
                        $sq = substr($sq, 0, -5);
                    }
                    $sq .=($where != " WHERE ")?")":"";
                    $this->sql .= $sq;
        }
        if(empty($setorder)){
            $setorder = "DESC";
        }
        if(!empty($setordenar)){
            if(is_array($setordenar)){
                $this->sql .= " ORDER BY ";
                foreach($setordenar as $nome  => $valor){
                    if($nome == '' || $valor == '')continue;
                    $this->sql .= "$nome $valor, ";
                }
                $this->sql = substr($this->sql, 0, -2);
            }else{
                $this->sql .= " ORDER BY ".$setordenar." ".$setorder;
            }
        }
        if(!empty($setstart) && !empty($setmax)){
            $this->SetLimit($setmax,$setstart);
        }
        }
        return $this->sql;
    }
    ######################################################################
    ## SETA OS VALORES DE LIMIT PARA O SQL                              ##
    ## SetLimit($setmax,$setstart);                                     ##
    ## $setmax = int => Numero de resultados a serem buscados           ##
    ## $setstart = STRING => Numero do registro inicial                 ##
    ######################################################################
    function SetLimit($setmax,$setstart){
        $this->sql .= " LIMIT ".$setmax.",".$setstart;
    }
    ######################################################################
    ## eXECUTA UMA BUSCA NO BANCO DEDADOS SQL                           ##
    ## SqlSelect($sql,$files,$line);                                    ##
    ## $sql = Querry Sql                                                ##
    ## $files = Arquivo executando o querry (__FILE__)                  ##
    ## $line = linha (__FILE__)                                         ##
    ######################################################################
    function SqlSelect($sql,$files=__FILE__,$line=__LINE__){
    $hdl = mysql_query($sql,$this->conexao) or $this->error_db($sql,$files,$line);
    return $hdl;
    }
    ######################################################################
    ## rETORNA UM ERRO DE SEL JUNTO COM SUA SINTAX                      ##
    ## error_db($sql,$files,$line);                                     ##
    ## $sql = Querry Sql                                                ##
    ## $files = Arquivo executando o querry (__FILE__)                  ##
    ## $line = linha (__FILE__)                                         ##
    ######################################################################
    function error_db($sql,$file,$line){
    $error = "SQL:".$sql ."<br/>File: ".basename($file)."<br/>Line: ".$line."<br/>".mysql_error();
    print ereg_replace("(\r\n|\n|\r|\t)", "<br />", $error);
    }
    ####################################################################
        ## ATUALIZA UMA TABELA DE ACORDO COM OS VALORES DENTRO DE UM ARRAY##                                  ##
    ## AS ENTRADAS Sï¿½O REFERENTES AO MYSQL                            ##
    ## FUNï¿½ï¿½O: SqlUpdate($tabela,$valores[,$item])                    ##
    ## $tabela = string/array - Nome das tabelas para consulta        ##
    ## $valores = string/array - valores para atualizar               ##
    ## $unico = string - condiï¿½ï¿½o de atualizaï¿½ï¿½o                      ##
    ####################################################################
    function SqlUpdate($tabela,$valores,$unico=false){
    if(is_array($tabela))
        $tabelas =  implode(",", $tabela);
        else
            $tabelas =  $tabela;
            $sql = "UPDATE $tabela SET ";
                if(count($valores >1)){
                foreach($valores as $chave => $valor){
                if($valor != ''){
                if($valor == 'NOW()')
                $sql .= "$chave = $valor";
                    else
                        $sql .= "$chave = '$valor'";
                    }else{
                        $sql .= "$chave = NULL";
                    }
                    $sql .=", ";
                    }
                    $sql = substr($sql, 0, -2);
                    }else{
                    if($valores[key($valores)] != '')
                    $sql .= key($valores)." = '".$valores[key($valores)]."'";
                    else
                        $sql .= key($valores)." = NULL";
                        }
                        if($unico != false)
                            $sql .= " WHERE $unico";
                        return $sql;
            }
            ######################################################################
            ## REMOVE UMA CONSULTA APARTIT DE UM COMPARAï¿½ï¿½O SQL UNICA           ##                                  ##
            ## AS ENTRADAS Sï¿½O REFERENTES AO MYSQL                              ##
            ## FUNï¿½ï¿½O: SqlDelete($tabela,$unico)                                ##
            ## $tabela = string/array - Nome das tabelas para consulta          ##
            ## $unico = sql where - condiï¿½ï¿½o de remoï¿½ï¿½o                         ##
            ######################################################################
            function SqlDelete($tabela,$unico=false){
            if(is_array($tabela))
                $tabelas =  implode(",", $tabela);
                else
                    $tabelas =  $tabela;
                    $sql = "DELETE FROM $tabelas ";
                    if($unico != false)
                        $sql .= " WHERE $unico";
                        return $sql;
                }
                ####################################################################
                ## INSERE VALORES DENTRO DE UMA TABELA                            ##
                ## AS ENTRADAS Sï¿½O REFERENTES AO MYSQL                            ##
                ## FUNï¿½ï¿½O: SqlInsert($tabela,$valores)                            ##
                ## $tabela = string - Nome das tabelas para consulta              ##
                ## $valores = string/array - valores para inserir na tabela       ##
                ####################################################################
                function SqlInsert($tabela,$valores){
                $sql = "INSERT INTO $tabela";
                if(is_array($valores)){
                foreach($valores as $chave => $valor){
                $val1[] = $chave;
                    if($valor == 'NOW()')
                        $val2[] = "NOW()";
                        else
                        $val2[] = "'".$valor."'";
                }
                }
                $chaves =  implode(", ", $val1);
            $valor =  implode(", ", $val2);
            $sql .= " ($chaves) VALUES ($valor)";
            return $sql;
    }
    ######################################################################
    ## RETORNA O NOME DAS COLUNAS DE UMA TABELA                         ##
    ## FUNï¿½ï¿½O: ListaCampos($smarty,$tabela,$pre)                        ##
    ## $smarty = OBJETO => OBJETO DE CONFIGURAï¿½ï¿½O                       ##
    ## $tabela = string - Nome das tabelas para consulta                ##
    ## $pre = BOLEAN - Se true coloca no nome da tabela na frente       ##
    ## RETORNA UM ARRAY COM OS NOMES                                    ##
    ######################################################################
    function ListaCampos(&$cfg,$tabela,$pre=false){
        $fields = @mysql_list_fields($cfg[db_name],$tabela, $this->conexao);
        $columns = @mysql_num_fields($fields);
        for ($i = 0; $i < $columns; $i++) {
            $tab[] = ($pre != false)?mysql_field_name($fields, $i):$tabela.'.'.mysql_field_name($fields, $i);
        }
        return $tab;
    }
}