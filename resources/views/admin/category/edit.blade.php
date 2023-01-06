@extends('admin.layouts.master')
@section('title', 'Edit Page')
@section('barContent')
    <h4>Edit CATEGORY LIST</h4>
@endsection
@section('content')
    <div class="row">
        <div class="col-3 offset-8">
            <a href="{{ route('category#list') }}"><button class="btn bg-dark text-white my-3">List</button></a>
        </div>
    </div>
    <div class="col-lg-6 offset-3">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2">Edit Category items</h3>
                </div>
                <hr>
                <form action="{{ route('category#update') }} " method="post" novalidate="novalidate">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="id" value="{{ $category->id }} ">
                        <label class="control-label mb-1">Name</label>
                        <input id="cc-pament" name="categoryName" type="text"
                            value="{{ old('categoryName', $category->name) }} "
                            class="form-control @error('categoryName') is-invalid @enderror" aria-required="true"
                            aria-invalid="false" placeholder="Seafood...">
                        @error('categoryName')
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
