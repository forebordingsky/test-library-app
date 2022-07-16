<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    private $apiSearchUrl = 'https://www.googleapis.com/books/v1/volumes';
    private $apiSearchFields = 'totalItems,items(id,volumeInfo(title,authors))';

    private $apiBookUrl = 'https://www.googleapis.com/books/v1/volumes/';
    private $apiBooksFields = 'id,volumeInfo(title,authors)';

    private $apiBookFields = 'id,volumeInfo(title,authors,description)';


    private function getUserBook($user_id,$book_id){
        return DB::table('book_user')
        ->where('user_id',$user_id)
            ->where('book_id',$book_id)->first();
    }

    public function booksPage(){
        $books = [];
        if(request('search')){
            $result = Http::get($this->apiSearchUrl,['q' => request('search'),'startIndex'=> request('page') ?? 0, 'maxResults' => 10, 'fields' => $this->apiSearchFields])->json();
            $total = $result['totalItems'];
            $books = $result['items'];

            return view('books.index',compact('books','total'));
        }
        return view('books.index',compact('books'));
    }

    public function bookPage($uuid){
        $book = Http::get($this->apiBookUrl . $uuid,['fields' => $this->apiBookFields])->json();
        return view('books.book',compact('book'));
    }

    public function userBooksPage(){
        //Получаем UUID книг, которые пользователь добавил себе в библиотеку.
        $userBooksIDs = DB::table('book_user')->where('user_id',auth()->user()->id)->get();
        $books = [];
        //Если получены UUID книг, то делаем запрос, чтобы получить информацию о книгах.
        if(count($userBooksIDs)){
            foreach ($userBooksIDs as $bookID){
                $books[] = Http::get($this->apiBookUrl . $bookID->book_id,['fields' => $this->apiBooksFields])->json();
            }
        }
        return view('books.library',compact('books'));

    }

    public function favoriteUserBooksPage(){
        //Получаем UUID книг, которые пользователь добавил себе в избранное.
        $userBooksIDs = DB::table('book_user')->where('user_id',auth()->user()->id)->where('favorite',true)->get();
        $books = [];
        //Если получены UUID книг, то делаем запрос, чтобы получить информацию о книгах.
        if(count($userBooksIDs)){
            foreach ($userBooksIDs as $bookID){
                $books[] = Http::get($this->apiBookUrl . $bookID->book_id,['fields' => $this->apiBooksFields])->json();
            }
        }
        return view('books.favorite',compact('books'));
    }

    public function addBookToUser(Request $request){
        //Поиск записи в базе данных
        $book = $this->getUserBook(auth()->user()->id,$request->input('book_id'));
        //Если запись найдена, то возвращаем сообщение.
        if($book){
            return back()->with('message','Книга уже была добавлена в вашу библиотеку.');
        }
        //Иначе добавляем запись в базу данных.
        DB::table('book_user')->insert([
            'user_id' => auth()->user()->id,
            'book_id' => $request->input('book_id')
        ]);
        return back()->with('message','Книга успешно добавлена в вашу библиотеку.');
    }
    public function removeBookFromUser(Request $request){
        //Поиск записи в базе данных.
        $book = $this->getUserBook(auth()->user()->id,$request->input('book_id'));
        //Если запись найдена, то удаляем запись из базы данных.
        if($book){
            DB::table('book_user')
                ->where('user_id',auth()->user()->id)
                    ->where('book_id',$request->input('book_id'))->delete();
            return back()->with('message','Книга успешно удалена из вашей библиотеки.');
        }
        //Иначе возвращаем ошибку.
        return back()->with('message','Этой книги нет в вашей библиотеке.');
    }

    public function addFavoriteBookToUser(Request $request){
        //Поиск записи в базе данных.
        $book = $this->getUserBook(auth()->user()->id,$request->input('book_id'));
        //Если запись найдена, то возвращаем сообщение.
        if($book){
            if($book->favorite){
                return back()->with('message','Книга уже была добавлена в избранное.');
            }else{
            //Иначе ищем и обновляем поле favorite нужной книги.
                DB::table('book_user')
                    ->where('user_id',auth()->user()->id)
                        ->where('book_id', request()->input('book_id'))
                            ->update(['favorite' => 1]);
                return back()->with('message','Книга была добавлена в избранное.');
            }

            return back()->with('message','Книга уже была добавлена в избранное.');
        }
        //Если запись о книге не была найдена, создаем новую запись и возвращаем сообщение.
        DB::table('book_user')->insert([
            'user_id' => auth()->user()->id,
            'book_id' => request()->input('book_id'),
            'favorite' => 1
        ]);
        return back()->with('message','Книга была добавлена в избранное.');

    }

    public function removeFavoriteBookFromUser(Request $request){
        //Поиск записи в базе данных.
        $book = $this->getUserBook(auth()->user()->id,$request->input('book_id'));
        //Если запись найдена и значение поля favorite равно true, то обновляем значение поля favorite
        if($book && $book->favorite){
            DB::table('book_user')
                    ->where('user_id',auth()->user()->id)
                        ->where('book_id', request()->input('book_id'))
                            ->update(['favorite' => 0]);
            return back()->with('message','Книга была удалена из избранного.');
        }
        //Если запись не найдена или значение поля favorite равно false, то возвращаем ошибку.
        return back()->with('message','Книга уже была удалена из избранного.');
    }


}
