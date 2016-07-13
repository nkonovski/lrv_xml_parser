<?php

namespace App\Http\Controllers;

use App\Books;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookController extends Controller
{

	private $dir = 'test/';

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$books = Books::where('active','1')->orderBy('created_at','desc')->paginate(10);
		$title = 'Latest Books';
		return view('home')->withBooks($books)->withTitle($title);
	}

	/**
	* Get data filtered by keyword
	*
	*@param string $keyword - author name
	*@return array
	*/
	public function search(Request $request)
	{

		$keyword = $request->input('search');
		if (empty($keyword))
		{
			$message = 'Please enter keyword.';
			return redirect('home')->withMessage($message);
		}

		$result = Books::where('title', 'LIKE', '%' . $keyword . '%')
				->orWhere('author', 'LIKE', '%' . $keyword . '%')
				->paginate(10);
		$message = count($result).' book(s) found.';

		return view('search')->withBooks($result)->withMessage($message);
	}

	/**
	 * action scan dir
	 */
	public function scan()
	{

		$res = self::scanDir();

		$message = $res.' book(s) was succesfuly added into database.';

		return redirect('home')->withMessage($message);

	}

	/**
	* Scan file structure recursivly.
	*@param string $dir - xml storage directory
	*@return int number of files
	*/
	public function scanDir($dir = '', $count = 0)
	{

		if (empty($dir))
		{
			$dir = $this->dir;
		}

		// read directory
		$dirHandle = opendir($dir);
		while($file = readdir($dirHandle))
		{

			//scan sub directory
			if($file === '.' || $file === '..')
			{
				//DO nothing
			}
			else if(is_dir($dir.$file."/"))
			{
				$count = $this->scanDir($dir.$file."/",$count);
			}
			else
			{
				//try to parse file
				if ($this->parseXml($dir.$file))
				{
					$count++;
				}
			}
		}

		return $count;

	}

	/**
	* Parse XML and save data int db
	*@param string $file - path to XML
	*@return bool
	*/
	public function parseXml($file)
	{

		//load simple xml object
		$xml = simplexml_load_file($file);

		if(!$xml)
		{
			return false;
		}

		$res = true;
		foreach($xml as $book)
		{
			// add new object for each book
			$duplicate = Books::where('title',$book->name)->first();
			if ($duplicate)
			{
				$res &= $duplicate->save();
			}
			else
			{
				$obj = new Books();
				$obj->title = $book->name;
				$obj->author = $book->author;
				$obj->active = 1;
				$res &= $obj->save();
			}

		}

		return $res;

	}

}
