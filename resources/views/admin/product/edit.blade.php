@extends('admin.layouts.master')
@section('title', 'Product Edit Page')
@section('barContent')
    <h4>EDIT PRODUCT LIST</h4>
@endsection
@section('content')
    <div class="row">
        <div class="col-3 offset-8">
            <i class="fa fa-arrow-left h4 bg-light px-2" aria-hidden="true" onclick="history.back()"></i>
        </div>
    </div>
    <div class="col-lg-6 offset-3 pb-5">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2">edit product items</h3>
                </div>
                <hr>
                {{-- {{ dd(Auth::product()->id) }} --}}
                <form action="{{ route('products#update', $product->id) }} " method="post" novalidate="novalidate"
                    enctype="multipart/form-data">
                    @csrf
                    {{-- {{ dd($product->id) }} --}}
                    <div class="form-group">
                        <label class="control-label mb-1">Name</label>
                        <input id="cc-pament" name="name" type="text" value="{{ old('name', $product->name) }} "
                            class="form-control @error('name') is-invalid @enderror" aria-required="true"
                            aria-invalid="false" placeholder="Seafood...">
                        @error('name')
                            <div class="invalid-feedback"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1">Category</label>
                        <select name="category" id=""class="form-control @error('category') is-invalid @enderror">
                            <option value="">Pizza category . . . . .

                            </option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }} " @if ($category->id == $product->category_id) selected @endif>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <div class="invalid-feedback"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1">Price</label>
                        <input id="cc-pament" name="price" type="number" placeholder="prize of pizza .."
                            class="form-control @error('price') is-invalid @enderror" aria-required="true"
                            aria-invalid="false">
                        @error('price')
                            <div class="invalid-feedback"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1">Description</label>
                        <textarea name="description"class="form-control @error('description') is-invalid @enderror" id=""
                            cols="30" rows="10">{{ old('description', $product->description) }} </textarea>
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
                            aria-invalid="false" placeholder="pizza waiting time...">
                        @error('waitingtime')
                            <div class="invalid-feedback"> {{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <button id="payment-button" type="submit" class="btn btn-lg btn-success btn-block">
                            <i class="fa-solid fa-cloud-arrow-up me-1"></i> <span id="payment-button-amount">Update</span>
                            {{-- <span id="payment-button-sending" style="display:none;">Sending…</span> --}}
                            {{-- <i class="fa-solid fa-circle-right"></i> --}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
