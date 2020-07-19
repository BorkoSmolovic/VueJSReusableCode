<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Evidention;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($evidention_id)
    {
        return Comment::where('isActive', 1)->where('evidention_id', $evidention_id)->get();
    }

    public function commentsDashboard()
    {
        $user = User::where('id', Auth::id())->first();
        if ($user->partner_id == null) {
            return array("evidentions" => DB::select("select e.id, e.event_name, u.name
from evidention_statuses es
         inner join evidentions e on es.evidention_id = e.id inner join users u on e.user_id = u.id
where es.status_id = 1
  and es.isActive = 1
  and es.status_id = (select max(es1.status_id)
                      from evidention_statuses es1
                      where es1.evidention_id = es.evidention_id
                        and es1.isActive = 1)"), "comments" => DB::select("select e.event_name, e.id, u.name
       from comments c inner join evidentions e on c.evidention_id = e.id and e.isActive = 1 inner join users u on c.user_id = u.id and u.isActive = 1
where c.isActive = 1
  and c.seen = 0
  and c.user_id <> $user->id
  and c.evidention_id in (select evidention_id
                        from evidention_statuses
                        where status_id > 1 and user_id = $user->id
                        group by evidention_id)
group by evidention_id
"));
        } else {
            return array("evidentions" => "null", "comments" => DB::select("select e.event_name, e.id, u.name
from comments c inner join evidentions e on c.evidention_id = e.id and e.isActive = 1 inner join users u on c.user_id = u.id and u.isActive = 1
where c.isActive = 1
  and c.seen = 0
  and c.user_id <> $user->id
    and evidention_id in
      (select e.id from users u inner join partners p on u.partner_id = p.id inner join contracts c on p.id = c.partner_id inner join evidentions e on e.contract_id = c.id where u.id = $user->id and u.isActive = 1 and p.isActive = 1 and c.isActive = 1)
group by evidention_id"));
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required',
            'evidention_id' => 'required'
        ]);

        $comment = Comment::create([
            'comment' => $request->comment,
            'evidention_id' => $request->evidention_id,
            'user_id' => Auth::id(),
        ]);

        return Comment::where('id', $comment->id)->first();
    }

    public function leaveMeSeen(Request $request)
    {
        $request->validate([
            'evidention_id' => 'required',
        ]);
        $user = User::where('id', Auth::id())->first();
        $comments = Comment::where('evidention_id', $request->evidention_id)->where('isActive', 1)->where('user_id', '!=', $user->id)->get();
        foreach ($comments as $comment) {
            $comment->update(['seen' => 1]);
        }

        return Comment::where('evidention_id', $request->evidention_id)->where('isActive', 1)->where('user_id', $user->id)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'comment' => 'required',
        ]);

        $comment->update([
            'comment' => $request->comment,
            'evidention_id' => $comment->evidention_id,
            'isActive' => $comment->isActive,
            'user_id' => Auth::id(),
        ]);

        return Comment::where('id', $comment->id)->first();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->update([
            'isActive' => !$comment->isActive,
            'user_id' => Auth::id(),
        ]);

        return Comment::where('id', $comment->id)->first();
    }
}
