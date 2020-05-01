<?php

namespace App\Http\Controllers;
use App\User;
use App\Drill;
use App\Problem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DrillsController extends Controller
{
    public function index(){
      $drills = Drill::all();
      return view('drills.index', compact('drills'));
    }
    public function mypage(){
      $drills = Auth::user()->drills;
      return view('drills.mypage', compact('drills'));
    }
    public function new()
    {
      return view('drills.new');
    }
    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_name' => 'required|string|max:255',
            'problem0' => 'required|string|max:255',
            'problem1' => 'required|nullable|max:255',
            'problem2' => 'required|nullable|max:255',
            'problem3' => 'string|nullable|max:255',
            'problem4' => 'string|nullable|max:255',
            'problem5' => 'string|nullable|max:255',
            'problem6' => 'string|nullable|max:255',
            'problem7' => 'string|nullable|max:255',
            'problem8' => 'string|nullable|max:255',
            'problem9' => 'string|nullable|max:255',
        ]);

        //モデルを使って、DBに登録する値をセット
        $drill = new Drill;
        $problem = new Problem;

        Auth::user()->drills()->save($drill->fill($request->all())); //保存可能
        $problem = $drill->problems()->save($problem);
//
        //$drill = Auth::user()->drills()->create(['id' => $request->input['drill_id']]);
        //
        //$problem = [];
        //$idx = 0;
        //        
        ////problemのnameがいくつ渡されるのか分からないので、とりあえず取得出来る限り保存するつもりでこんな書き方にしましたが、//実際の取得        した結果で上手くように調整してください。
        //while($problem = $request->input[sprintf('problem%d', $idx++)]){
        //  $problem[] = ['name' => $problem ];
        //}
        //
        ////取得したproblem_namesを一括で保存してみます。
        ////problemsの中身は、Problemのモデルインスタンスを沢山持つCollectionです。
        //$problem = $drill->problems()->createMany($problem);
//
//
//
        //// １つ１つ入れるか
//      //  $drill->title = $request->title;
//      //  $drill->category_name = $request->category_name;
//      //  $drill->save();

        // fillを使って一気にいれるか
        // $fillableを使っていないと変なデータが入り込んだ場合に勝手にDBが更新されてしまうので注意！
        //$drill->fill($request->all())->save();

        // リダイレクトする
        // その時にsessionフラッシュにメッセージを入れる
        return redirect()->route('drills.new')->with('flash_message', __('Registered.'));
    }

    //アクションの実装
    public function show($id)
  {
    // GETパラメータが数字かどうかをチェックする
    if(!ctype_digit($id)){
        return redirect('/drills/new')->with('flash_message', __('Invalid operation was performed.'));
    }

    $drill = Drill::find($id);

    return view('drills.show', ['drill' => $drill]);
  }

    //編集画面のコントローラー
    public function edit($id){
      // GETパラメータが数字かどうかをチェックする
      // 事前にチェックしておくことでDBへの無駄なアクセスが減らせる（WEBサーバーへのアクセスのみで済む）
      if(!ctype_digit($id)){
        return redirect('/dtills/new')->with('flash_message', __('Invalid operation was performed.'));
      }

      //$drill = Drill::find($id);
      $drill = Auth::user()->drills()->find($id);

      return view('drills.edit', ['drill' => $drill]);
    }

    //更新処理用のアクションの実装
    public function update(Request $request, $id)
    {
    // GETパラメータが数字かどうかをチェックする
    if(!ctype_digit($id)){
        return redirect('/drills/new')->with('flash_message', __('Invalid operation was performed.'));
    }
    $drill = Drill::find($id);
    $drill->fill($request->all())->save();

    return redirect('/drills')->with('flash_message', __('Registered.'));
  }

  //削除処理用のアクションの実装
  public function delete($id){
    //$drill = Auth::user()->drills()->find($id);
    //Drill::find($id)->delete();
    if(Auth::user()->drills()->find($id)){
      Drill::find($id)->delete();
    return redirect('/drills')->with('flash_message', __('Deleted.'));
    }else{
      return redirect('/drills')->with('flash_message', __('NonDeleted.'));
    }

  }
}

  //public function destroy($id){
  //  //GETパラメーターが数字かどうかチェックする
  //  if(!ctype_digit($id)){
  //    return redirect('/drills/new')->with('flash_message',__('Invalid operation was performed.'));
  //  }
  //  // $drill = Drill::find($id);
  //  // $drill->delete();
  //
  //  // こう書いた方がスマート
  //  Drill::find($id)->delete();
//
  //  return redirect('/drills')->with('flash_message', __('Deleted.'));
  //}
