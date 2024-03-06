<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class boardController extends Controller
{
    /**
     * @OA\Post (
     *     path="/boards",
     *     tags={"게시판"},
     *     summary="게시글 등록",
     *     description="게시글을 등록",
     *     @OA\RequestBody(
     *         description="게시글 정보",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema (
     *                 @OA\Property (property="board_title", type="string", description="게시글 제목", example="공지사항입니다."),
     *                 @OA\Property (property="board_content", type="string", description="게시글 내용", example="공지사항 내용입니다.")
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Fail")
     * )
     */
    public function store(Request $request) {

        $request = $request->validate([
            'board_title' => 'required',
            'board_content' => 'required'
        ]);
        $this->board->create([
            'board_title' => $request['board_title'],
            'board_content' => $request['board_content'],
            'created_at' => now(),
            'updated_at' => null
        ]);

        return redirect()->route('board.index');
    }

    public function show(Board $board) {
        return view('boards.detail', compact('board'));
    }

    public function edit(Board $board) {
        return view('boards.edit', compact('board'));
    }

    /**
     * @OA\Put (
     *     path="/boards/{board_id}",
     *     tags={"게시판"},
     *     summary="게시글 수정",
     *     description="게시글을 수정",
     *     @OA\Parameter (name="board_id", in="path", description="게시글 PK"),
     *     @OA\RequestBody(
     *         description="게시글 정보",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema (
     *                 @OA\Property (property="board_title", type="string", description="게시글 제목", example="공지사항입니다."),
     *                 @OA\Property (property="board_content", type="string", description="게시글 내용", example="공지사항 내용입니다.")
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Fail")
     * )
     */
    public function update(Board $board, Request $request) {
        $request = $request->validate([
            'board_title' => 'required',
            'board_content' => 'required'
        ]);
        $board->update([
            'board_title' => $request['board_title'],
            'board_content' => $request['board_content'],
            'updated_at' => now()
        ]);
        return redirect()->route('board.index');
    }

    /**
     * @OA\Delete (
     *     path="/boards/{board_id}",
     *     tags={"게시판"},
     *     summary="게시글 삭제",
     *     description="게시글을 삭제",
     *     @OA\Parameter (name="board_id", in="path", description="게시글 PK"),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Fail")
     * )
     */
    public function destroy(Board $board) {
        $board->delete();
        return redirect()->route('board.index');
    }
}
