@extends('orangtua.layouts.app')


@section('title','Ganti Password')



@section('content')


<div class="max-w-xl mx-auto">



    <div class="
        bg-white
        rounded-2xl
        border
        shadow-sm
        p-8
    ">


        <div class="text-center mb-6">


            <div class="
                w-16
                h-16
                mx-auto
                rounded-full
                bg-indigo-100
                text-indigo-600
                flex
                items-center
                justify-center
                text-2xl
                mb-4
            ">

                🔐

            </div>



            <h2 class="
                text-2xl
                font-bold
                text-slate-800
            ">

                Ganti Password

            </h2>



            <p class="
                text-sm
                text-slate-500
                mt-2
            ">

                Untuk keamanan akun, silakan buat password baru minimal 8 karakter.

            </p>


        </div>







        {{-- SUCCESS --}}


        @if(session('success'))


        <div class="
            bg-emerald-50
            border
            border-emerald-200
            text-emerald-700
            px-4
            py-3
            rounded-xl
            mb-5
            text-sm
        ">


            {{ session('success') }}


        </div>


        @endif







        {{-- ERROR --}}


        @if(session('error'))


        <div class="
            bg-red-50
            border
            border-red-200
            text-red-700
            px-4
            py-3
            rounded-xl
            mb-5
            text-sm
        ">


            {{ session('error') }}


        </div>


        @endif







        {{-- VALIDATION --}}


        @if($errors->any())


        <div class="
            bg-red-50
            border
            border-red-200
            text-red-700
            px-4
            py-3
            rounded-xl
            mb-5
            text-sm
        ">


            <ul class="list-disc ml-5">


                @foreach($errors->all() as $error)


                <li>

                    {{ $error }}

                </li>


                @endforeach


            </ul>


        </div>


        @endif







        <form

            method="POST"

            action="{{ route('orangtua.password.update') }}"

        >


            @csrf







            <div class="mb-5">


                <label class="
                    block
                    text-sm
                    font-semibold
                    text-slate-700
                    mb-2
                ">


                    Password Baru


                </label>




                <input


                    type="password"


                    name="password"


                    class="
                        w-full
                        border
                        border-slate-300
                        rounded-xl
                        px-4
                        py-3
                        focus:outline-none
                        focus:ring-2
                        focus:ring-indigo-500
                    "


                    placeholder="Minimal 8 karakter"


                    required


                >



            </div>









            <div class="mb-6">


                <label class="
                    block
                    text-sm
                    font-semibold
                    text-slate-700
                    mb-2
                ">


                    Konfirmasi Password


                </label>




                <input


                    type="password"


                    name="password_confirmation"


                    class="
                        w-full
                        border
                        border-slate-300
                        rounded-xl
                        px-4
                        py-3
                        focus:outline-none
                        focus:ring-2
                        focus:ring-indigo-500
                    "


                    placeholder="Ulangi password baru"


                    required


                >



            </div>









            <button


                type="submit"


                class="
                    w-full
                    bg-indigo-600
                    hover:bg-indigo-700
                    text-white
                    font-semibold
                    py-3
                    rounded-xl
                    transition
                    shadow-sm
                "


            >


                Simpan Password


            </button>




        </form>




    </div>



</div>


@endsection