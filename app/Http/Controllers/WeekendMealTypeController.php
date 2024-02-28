<?php

namespace App\Http\Controllers;

use App\Models\WeekendMealType;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class WeekendMealTypeController extends Controller
/**
     * @OA\Post (
     *     path="/api/weekend/mealtype",
     *     tags={"식수"},
     *     summary="식수 주말 신청",
     *     description="식수 주말 신청을 처리합니다",
     *         @OA\RequestBody(
     *             description="학생 식사 신청 정보",
     *             required=true,
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema (
     *                     @OA\Property (property="content", type="string", description="식사유형 설명", example="223식 1식3,500"),
     *                     @OA\Property (property="meal_type", type="string", description="식사유형", example="A"),
     *                     @OA\Property (property="price", type="string", description="가격", example="750,000"),
     *                     @OA\Property (property="date", type="string", description="식사시간", example="lunch"),
     *                 )
     *             )
     *         ),
     *         @OA\Response(response="200", description="Success"),
     *         @OA\Response(response="500", description="Fail"),
     * )
     */
{
    
    public function store(Request $request)
    {
        try {
            // 유효성 검사
            $validatedData = $request->validate([
                'meal_type' => 'required|string',
                'content' => 'nullable|string',
                'price' => 'required|string',
                'date' => 'required|string',
            ]);
        } catch (ValidationException $exception) {
            // 유효성 검사 실패시 애러 메세지
            return response()->json(['error' => $exception->getMessage()], 422);
        }

        try {
            // 데이터베이스에 저장
            WeekendMealType::create([
                'meal_type' => $validatedData['meal_type'],
                'content' =>$validatedData['content'],
                'price' =>$validatedData['price'],
                'date' =>$validatedData['date'],
            ]);
        } catch (\Exception $exception) {//Exception는 부모 예외 클래스임
            // 데이터베이스 저장 실패시 애러 메세지
            return response()->json(['error' => '데이터베이스에 저장하는 중에 오류가 발생했습니다.'], 500);
        }
        
        // 성공 메시지
        return response()->json(['message' => '주말 식사 유형 저장 완료']);
    }
}
