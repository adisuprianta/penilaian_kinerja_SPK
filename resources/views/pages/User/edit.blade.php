@extends('layouts.default')
@section('title','Edit User')
@section('header-title','Edit User '.$nama->name)

@section('content')


<x-guest-layout>
    <x-auth-card>
 
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('user.update',$nama->id) }}">
            @method('PUT')
            @csrf
            @foreach($user as $u)
            <!-- Name -->
            
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name"  class="block mt-1 w-full" type="text" name="name" value="{{$u->name}}"  required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{$u->email}}" required />
            </div>
            
             <!-- Role -->
             <div class="mt-4">
                <x-label for="Role" :value="__('Role')" />

                <select id="role" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full"  type="role" name="role"  required>
                    @foreach($role as $r)
                    @if($u->id == $r->id)
                        <option value="{{$r->id}}" selected >{{$r->display_name}}</option>
                    @else
                    <option value="{{$r->id}}"  >{{$r->display_name}}</option>
                    @endif
                    @endforeach
                    
                </select>
                
            </div>
            <div class="mt-4">
                <x-label for="perusahaan" :value="__('Perusahaan')" />

                <select id="perusahaan" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full"  type="role" name="perusahaan"  required>
                <option value="null" selected>-</option>
                    @foreach($perusahaan as $p)
                        @if($p->id_perusahaan == $u->id_perusahaan)
                        <option value="{{$p->id_perusahaan}}" selected>{{$p->nama_perusahaan}}</option>                       
                        @else
                        <option value="{{$p->id_perusahaan}}">{{$p->nama_perusahaan}}</option>
                        @endif
                    @endforeach
                    
                </select>
                
            </div>

            <!-- Password -->
            

            <div class="flex items-center justify-end mt-4">
                

                <x-button class="ml-4">
                    {{ __('update') }}
                </x-button>
            </div>
            @endforeach
        </form>
    </x-auth-card>
</x-guest-layout>

@endsection