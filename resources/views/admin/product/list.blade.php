@extends('admin.main')

@section('content')
    <table class="table">
        <thead>
            <tr>

                <th style="width: 50px">ID</th>
                <th>Tên sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Mô tả</th>
                <th>Chi tiết mô tả</th>
                <th>Danh mục</th>
                <th>Giá gốc</th>
                <th>Giá giảm</th>
                <th>Kích hoạt</th>
                <th>Thời gian cập nhật</th>
                <th>Cập nhật</th>
                <th style="width: 100px">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $key => $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td><a href="{{ $product->thumb }}" target="_blank"><img src="{{ $product->thumb }}" width="150px"></a>
                    </td>
                    <td>{{ $product->content }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->menu->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->price_sale }}</td>
                    <td>{!! \App\Helpers\Helper::active($product->active) !!}</td>
                    <td>{{ $product->updated_at }}</td>
                    <td>
                        <a href="/admin/products/edit/{{ $product->id }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="btn btn-danger btn-sm"
                            onclick="removeRow({{ $product->id }}, '/admin/products/destroy')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
