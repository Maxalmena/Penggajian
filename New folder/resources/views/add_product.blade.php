@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="text-center">Insert New Product</h3>
            </div>
            <div class="box-body">
                <div class="col-md-12">
                    <form class="form-horizontal" method="POST" action="{{ route('add_product') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('jenis') ? ' has-error' : '' }}">
                            <label for="jenis" class="col-md-2">Type</label>

                            <div style="padding-left: 0" class="col-md-6">
                                <div style="padding-left: 0" class="col-md-3">
                                    <input type="radio" name="jenis" id="currency" value="1" > <label for="currency">Currency</label>
                                </div>
                                <div style="padding-left: 0" class="col-md-3">
                                    <input type="radio" name="jenis" id="item&skin" value="2" > <label for="item&skin">Item & Skin</label>
                                </div>

                                @if ($errors->has('jenis'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('jenis') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" style="padding-right: 0" class="col-md-2 ">Item Name</label>
                            <div style="padding-left: 0" class="col-md-10">
                                <input id="name" type="text"  class="form-control" name="name" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                            <label for="category" style="padding-right: 0" class="col-md-2 ">Select Games</label>

                            <div style="padding-left: 0" class="col-md-10">
                                <select name="category" id="category">
                                    <option value="-1">Select Category</option>
                                    @foreach ($categories as $category)
                                    @if (old('category') == $category->id)
                                    <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                    @else
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                    @endforeach
                                </select>

                                @if ($errors->has('category'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('category') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" style="padding-right: 0" class="col-md-2 ">Description</label>

                            <div style="padding-left: 0" class="col-md-10">
                                <textarea name="description" id="description" cols="35" rows="5">{{ old('description') }}</textarea>

                                @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            <label for="image" style="padding-right: 0" class="col-md-2 ">Image</label>

                            <div style="padding-left: 0" class="col-md-10">
                                <input type="file" name="image" id="image">

                                @if ($errors->has('image'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('totunit') ? ' has-error' : '' }}">
                            <label for="totunit" style="padding-right: 0" class="col-md-2 ">Total Unit</label>

                            <div style="padding-left: 0" class="col-md-10">
                                <input type="text" class="form-control" name="totunit" id="totunit" value="{{ old('totunit') }}">

                                @if ($errors->has('totunit'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('totunit') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="price" style="padding-right: 0" class="col-md-2 ">Price</label>

                            <div style="padding-left: 0" class="col-md-10">
                                <input id="price" type="text" class="form-control" name="price" value="{{ old('price') }}">

                                @if ($errors->has('price'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('deliv') ? ' has-error' : '' }}">
                            <label for="deliv" class="col-md-2">Delivery Guarentee</label>

                            <div style="padding-left: 0" class="col-md-10">
                                <div style="padding-left: 0" class="col-md-2">
                                    <input type="radio" name="deliv" id="20menit" value="20 menit" > <label for="20menit">20 menit</label>
                                </div>
                                <div style="padding-left: 0" class="col-md-2">
                                    <input type="radio" name="deliv" id="2jam" value="2 jam" > <label for="2jam">2 Jam</label>
                                </div>
                                <div style="padding-left: 0" class="col-md-2">
                                    <input type="radio" name="deliv" id="5jam" value="5 jam" > <label for="5jam">5 Jam</label>
                                </div>
                                <div style="padding-left: 0" class="col-md-2">
                                    <input type="radio" name="deliv" id="10jam" value="10 jam" > <label for="10jam">10 Jam</label>
                                </div>
                                <div style="padding-left: 0" class="col-md-4">
                                    <input type="radio" name="deliv" id="kosong" value="kosong" > <input type="text" name="deliver">
                                </div>
                                @if ($errors->has('deliv'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('deliv') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('dur') ? ' has-error' : '' }}">
                            <label for="dur" class="col-md-2">Duration</label>

                            <div style="padding-left: 0" class="col-md-10">
                                <div style="padding-left: 0" class="col-md-2">
                                    <input type="radio" name="dur" id="3hari" value="3" > <label for="3hari">3 Hari</label>
                                </div>
                                <div style="padding-left: 0" class="col-md-2">
                                    <input type="radio" name="dur" id="7hari" value="7" > <label for="7hari">7 Hari</label>
                                </div>
                                <div style="padding-left: 0" class="col-md-2">
                                    <input type="radio" name="dur" id="14hari" value="14" > <label for="14hari">14 Hari</label>
                                </div>
                                <div style="padding-left: 0" class="col-md-2">
                                    <input type="radio" name="dur" id="30hari" value="30" > <label for="30hari">30 Hari</label>
                                </div>

                                @if ($errors->has('jenis'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('jenis') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div style="padding-left: 0" class="col-md-10 col-md-offset-2">
                                <button type="submit" class="btn btn-primary">
                                    Insert New Clothes
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection