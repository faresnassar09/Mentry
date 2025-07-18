@extends('users.layouts.app')
@section('title',$title)
@section('content')

<div class="overflow-x-auto mt-6">
  <table class="min-w-full text-sm text-right text-gray-700 border border-gray-200 rounded-xl overflow-hidden">
    <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
      <tr>
        <th class="px-6 py-3">اسم الملف</th>
        <th class="px-6 py-3">النوع</th>
        <th class="px-6 py-3">تاريخ الإضافة</th>
        <th class="px-6 py-3">آخر تعديل</th>
        <th class="px-6 py-3 text-center">إجراءات</th>
      </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-100">


    @foreach ($materials as $material )
        

      <tr class="hover:bg-gray-50 transition-all duration-150">
        <td class="px-6 py-4 font-medium text-gray-900">{{$material->title}}</td>

        <td class="px-6 py-4">
    @if($material->type == 1)
        <!-- ملزمة -->
        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
            ملزمة
        </span>
    @else
        <!-- ملخص -->
        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
            ملخص
        </span>
    @endif
</td>
        <td class="px-6 py-4 text-sm text-gray-500">{{$material->created_at->format('Y:m:d')}}</td>
        <td class="px-6 py-4 text-sm text-gray-500">{{$material->last_read}}</td>

        <td class="px-6 py-4 flex justify-center gap-2">

          <!-- عرض -->
          <a href="{{route('users.study.materials.view',$material->id)}}" class="inline-flex items-center px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded-md shadow">
            👁️ عرض
</a>

          <!-- تحميل -->
          <a href="{{route('users.study.materials.download',$material->id)}}" class="inline-flex items-center px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-medium rounded-md shadow">
            ⬇️ تحميل
</a>

          <!-- حذف -->
          <form action="{{route('users.study.materials.delete',$material->id)}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this file?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 text-sm text-white bg-red-600 rounded hover:bg-red-700">
                                            حذف
                                        </button>
                                    </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>


@endsection