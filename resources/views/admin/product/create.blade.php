@extends('admin.layouts.master')
@section('title', 'Create Page')
@section('barContent')
    <h4>ADD PRODUCT LIST</h4>
@endsection
@section('content')
    <div class="row">
        <div class="col-3 offset-8">
            <a href="{{ route('products#list') }}"><button class="btn bg-dark text-white my-3">List</button></a>
        </div>
    </div>
    <div class="col-lg-6 offset-3 pb-5">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2">Add product items</h3>
                </div>
                <hr>
                <form action="{{ route('products#create') }} " method="post" novalidate="novalidate"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="control-label mb-1">Name</label>
                        <input id="cc-pament" name="name" type="text" value="{{ old('name') }} "
                            class="form-control @error('name') is-invalid @enderror" aria-required="true"
                            aria-invalid="false" placeholder="Product . . .">
                        @error('name')
                            <div class="invalid-feedback"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1">Category</label>
                        <select name="category" id=""class="form-control @error('category') is-invalid @enderror">
                            <option value="">Choose product category . . . . .</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }} ">{{ $category->name }} </option>
                            @endforeach
                        </select>
                        @error('category')
                            <div class="invalid-feedback"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1">Price</label>
                        <input id="cc-pament" name="price" type="number" value="{{ old('price') }} "
                            class="form-control @error('price') is-invalid @enderror" aria-required="true"
                            aria-invalid="false" placeholder="Product Price . . .">
                        @error('price')
                            <div class="invalid-feedback"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1">Description</label>
                        <textarea name="description"class="form-control @error('description') is-invalid @enderror" id=""
                            cols="30" rows="10" placeholder="This product is...">{{ old('description') }} </textarea>
                        @error('description')
                            <div class="invalid-feedback"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1 me-5">Image</label>
                        <input type="file" name="image" id=""
                            class="form-control @error('image') is-invalid @enderror">
                        @error('image')
                            <div class="invalid-feedback"> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="control-label mb-1">Wating Time</label>
                        <input id="cc-pament" name="waitingtime" type="number"
                            class="form-control @error('waitingtime') is-invalid @enderror" aria-required="true"
                            aria-invalid="false" placeholder="Waiting time  . . .">
                        @error('waitingtime')
                            <div class="invalid-feedback"> {{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                            <span id="payment-button-amount">Create</span>
                            {{-- <span id="payment-button-sending" style="display:none;">Sending…</span> --}}
                            {{-- <i class="fa-solid fa-circle-right"></i> --}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
