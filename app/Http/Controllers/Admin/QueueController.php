<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// use
use App\Job;
use App\FailedJob;

class QueueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = Job::orderBy('id', 'desc')->paginate(config('admin.admin_post_size'));
        return view( 'admin/job/index', compact('jobs') );
    }

    public function failed()
    {
        $jobs = FailedJob::orderBy('id', 'desc')->paginate(config('admin.admin_post_size'));
        return view( 'admin/job/failed', compact('jobs') );
    }

}
