@extends('layouts.admin', ['title' => 'Product Add'])

@section('mainContent')
    <div class="container mt-1">

      {{-- jodi sobkichu thik thake tahole --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- jodi any error thake tahole --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="product-form" action=" {{ route('products.store') }} " method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group ">
                <label class="form-label" for="name">Product Name:</label>
                <input class="form-control" type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="description">Product Description:</label>
                <textarea class="form-control" name="description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label" for="image">Product Image:</label>
                <input type="file" name="image" class="form-control" required>
            </div>
            <div id="features" class="form-group mt-2">
                <h3>Features</h3>
                <div class="feature">
                    <input class="form-control m-2" type="text" name="features[0][feature_name]"
                        placeholder="Feature Name" required>
                    <input class="form-control m-2" type="text" name="features[0][feature_description]"
                        placeholder="Feature Description">
                </div>
            </div>
            <button class="btn btn-primary" type="button" onclick="addFeature()">Add Feature</button>
            <button class="btn btn-primary" type="submit">Create Product</button>
        </form>

        <script>
            let featureCount = 1;

            function addFeature() {
                const featureDiv = document.createElement('div');
                featureDiv.classList.add('feature');
                featureDiv.innerHTML = `
            <input type="text" name="features[${featureCount}][feature_name]" placeholder="Feature Name" required>
            <input type="text" name="features[${featureCount}][feature_description]" placeholder="Feature Description">
        `;
                document.getElementById('features').appendChild(featureDiv);
                featureCount++;
            }
        </script>

    </div>

    <script>
        $("#imgSrc").attr('src', "https://ui-avatars.com/api/?background=random&color=fff&name={{ auth()->user()->name }}")
    </script>
@endsection
