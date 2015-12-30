<?php
/*--------
By      : Teysseire Guillaume
Date    : 12/03/2015
Update  : 30/12/2015
Licence : © Copyright
Version : 1.0
-------------------------
*/
class Page
{
	public function __construct() 
    {

    }
    
    //--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
    static public function get( $id )
    {
    	$data =  R::load( 'page', $id );
        if(!empty($data))
            $data['body'] = Page::getBody( $data['filename'] );
        return $data;
    }
    //--------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------
    //
    //
    //
    //--------------------------------------------------------------------------------
    static public function getByUrl( $url )
    {
        $data = R::findOne( 'page', 'url=?', [ $url ] );
        if(!empty($data))
            $data['body'] = Page::getBody( $data['filename'] );
        return $data;
    }

    //--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
    /*
    titre
    tag
    auteur
    path
    body
    type ( 0:page, 1:article, 2:event )
    twig
    date
    */
    static public function add( $data )
    {
        //verification de l'id dispo
        $compte = 0;
        $buffer = FoxFWKernel::URLencode( $data['titre']);
        while( !empty(R::find( 'page', 'url=?', [ $buffer ])) )
        {
            $compte++;
            $buffer = FoxFWKernel::URLencode( $data['titre'].'-'.$compte );
        }

        //preparation de l'article
    	$article           = R::dispense( 'page' );
        $article->url      = $buffer;
    	$article->titre    = $data['titre'];
    	$article->tag      = $data['tag'];
    	$article->auteur   = $data['auteur'];
    	$article->filename = ($data['path'].$buffer.'.html');
        $article->type     = $data['type'];
        $article->twig     = $data['twig'];
        $article->img      = '';
        $article->date     = time();

        if( isset( $data['date'] ))
            $article->date = $data['date'];

        //création du fichier qui recevra le body
        file_put_contents( $article->filename, $data['body'] );
        if( !file_exists( $article->filename) )//si le fichier existe pas
            die( 'Erreur Création fichier BODY !: '.$article->filename );

        
        //telechargement de l'image
        $buffer = FoxFWFile::uploadFile( $data['path'] );
        if( isset($buffer[0]))
            $article->img = $buffer[0];

    	R::store( $article );
        
        return $article->url;
    }

    //--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
    static public function update( $id, $data )
    {
    	$article = R::load( 'page', $id );

        //si existe
        if( $article == NULL )
            return false;

        //update
        if( isset($data['titre']))
    	   $article->titre = $data['titre'];

        if( isset($data['tag']))
    	   $article->tag = $data['tag'];

        if( isset($data['auteur']))
    	   $article->auteur = $data['auteur'];

        if( isset($data['type']))
            $article->type = $data['type'];

        if( isset($data['twig']))
            $article->twig = $data['twig'];

        if( isset($data['date']))
            $article->twig = $data['date'];

        //body
        if( isset($data['body']) )
            file_put_contents( $article->filename, $data['body']);
        
        //image
        if( isset($data['img']))
        if( $data['img'] != NULL )
        {
            $path = realpath('./');
            unlink( $path.'/'.$article->img );
            $article->img = $data['img'];
        }
        
    	R::store( $article );

        return $article->url;
    }

    //--------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------
    //
    //
    //
    //--------------------------------------------------------------------------------
    static public function search( $tag )
    {
        $data = R::find( 'page', 'tag LIKE ? ORDER by date DESC', [ '%'.$tag.'%' ] );
        
        if(!empty( $data ))
        foreach ( $data as $key )
            $key->body = Page::getBody( $key->filename );

        return $data;
    }

    //--------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------
    //
    //
    //
    //--------------------------------------------------------------------------------
    /* min, max, type, order_by(data,titre)*/
    static public function liste( $json = NULL )
    {
        //préparation des paramettre
        $limit_min = 0;
        $limit_max = 999;
        $type = '';
        $order_by = 'date';

        if( $json != NULL )
        {
            //configuration paramettr
            if( isset($json['min']))
                $limit_min = $json['min'];

            if( isset($json['max']))
                $limit_max = $json['max'];

            if( isset($json['type']))
                $type = ('type="'.$json['type'].'"');

            if( isset($json['order_by']))
                $order_by = $json['order_by'];
        }

        //recherche
        $data = R::find( 'page', $type.' ORDER by ? DESC, date DESC LIMIT ?,?', 
            [ $order_by, $limit_min, $limit_max ] );
        
        //recuperer le body
        if(!empty( $data ))
        foreach( $data as $key )
            $key->body = Page::getBody( $key->filename );
        return $data;
    }


    //--------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------
    //
    //
    //
    //--------------------------------------------------------------------------------
    static private function getBody( $file )
    {
        if( file_exists( $file ))
            return file_get_contents( $file );
        return 'Error File Body !';
    }

    //--------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------
    //
    //
    //
    //--------------------------------------------------------------------------------
    static public function remove( $id, $all = true )
    {
        $data = R::load( 'page', $id );
        if( $data->id == 0 )
            return '';
        $url = $data->url;

        if( $all )
        {
            $path = realpath('./');
            unlink( $path.'/'.$data->img );
            unlink( $path.'/'.$data->filename );
        }
        R::trash( $data );
        return $url;
    }

    //--------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------
    //
    //
    ////ERREUR ? //TODO
    //--------------------------------------------------------------------------------
    static public function getAllType()
    {
        return R::exec('SELECT DISTINCT type FROM fowfwpage');
    }
};