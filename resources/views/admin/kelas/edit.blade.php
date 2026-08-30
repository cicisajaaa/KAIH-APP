@extends('admin.layouts.app')


@section('title','Edit Kelas')


@section('content')



<div class="max-w-2xl">


    <div class="mb-6">


        <h2 class="text-3xl font-bold text-gray-800">

            Edit Kelas

        </h2>


        <p class="text-gray-500 mt-1">

            Ubah informasi kelas.

        </p>


    </div>







    <div class="bg-white rounded-xl shadow p-6">



        <form 
            action="{{ route('kelas.update',$kelas->id) }}" 
            method="POST"
        >


            @csrf

            @method('PUT')





            {{-- Nama Kelas --}}


            <div class="mb-5">


                <label class="block mb-2 font-semibold text-gray-700">

                    Nama Kelas

                </label>



                <input
                    type="text"
                    name="nama_kelas"
                    value="{{ old('nama_kelas',$kelas->nama_kelas) }}"
                    class="
                    w-full
                    border
                    rounded-lg
                    px-4
                    py-3
                    "
                    required
                >



            </div>










            {{-- Jurusan --}}



            <div class="mb-6">


                <label class="block mb-2 font-semibold text-gray-700">

                    Jurusan

                </label>




                <select
                    name="jurusan_id"
                    class="
                    w-full
                    border
                    rounded-lg
                    px-4
                    py-3
                    "
                >



                    <option value="">

                        -- Tanpa Jurusan --

                    </option>





                    @foreach($jurusans as $jurusan)



                    <option

                        value="{{ $jurusan->id }}"

                        {{ 
                            old(
                                'jurusan_id',
                                $kelas->jurusan_id
                            ) == $jurusan->id 
                            ? 
                            'selected' 
                            : 
                            ''
                        }}

                    >

                        {{ $jurusan->nama_jurusan }}

                    </option>




                    @endforeach



                </select>



            </div>








            <div class="flex gap-3">


                <button
                    type="submit"
                    class="
                    bg-indigo-600
                    hover:bg-indigo-700
                    text-white
                    px-5
                    py-3
                    rounded-lg
                    font-semibold
                    "
                >

                    Update

                </button>





                <a
                    href="{{ route('kelas.index') }}"
                    class="
                    bg-gray-500
                    hover:bg-gray-600
                    text-white
                    px-5
                    py-3
                    rounded-lg
                    "
                >

                    Batal

                </a>



            </div>




        </form>



    </div>



</div>




@endsection