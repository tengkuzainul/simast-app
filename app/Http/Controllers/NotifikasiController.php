<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
          /**
           * Display a listing of notifications for current user
           */
          public function index()
          {
                    $user = Auth::user();

                    $notifikasis = Notifikasi::where('target_role', $user->role)
                              ->orderBy('created_at', 'desc')
                              ->paginate(10);

                    $breadcrumbs = [
                              ['label' => 'Dashboard', 'url' => route('home')],
                              ['label' => 'Notifikasi'],
                    ];

                    return view('notifikasi.index', [
                              'breadcrumbs' => $breadcrumbs,
                              'title' => 'Daftar Notifikasi',
                              'notifikasis' => $notifikasis,
                    ]);
          }

          /**
           * Display the specified notification detail
           */
          public function show(Notifikasi $notifikasi)
          {
                    $user = Auth::user();

                    // Check if user has permission to view this notification
                    if ($notifikasi->target_role !== $user->role) {
                              abort(403, 'Unauthorized access to this notification');
                    }

                    // Mark as read if it's unread
                    if ($notifikasi->status === 'Unread') {
                              $notifikasi->update(['status' => 'read']);
                    }

                    $breadcrumbs = [
                              ['label' => 'Dashboard', 'url' => route('home')],
                              ['label' => 'Notifikasi', 'url' => route('notifikasi.index')],
                              ['label' => 'Detail Notifikasi'],
                    ];

                    return view('notifikasi.detail', [
                              'breadcrumbs' => $breadcrumbs,
                              'title' => 'Detail Notifikasi',
                              'notifikasi' => $notifikasi,
                    ]);
          }

          /**
           * Mark notification as read
           */
          public function markAsRead(Notifikasi $notifikasi)
          {
                    $user = Auth::user();

                    if ($notifikasi->target_role === $user->role) {
                              $notifikasi->update(['status' => 'read']);

                              // Check if it's AJAX request
                              if (request()->expectsJson()) {
                                        return response()->json(['success' => true]);
                              }

                              return redirect()->back()->with('success', 'Notifikasi telah ditandai sebagai dibaca');
                    }

                    if (request()->expectsJson()) {
                              return response()->json(['success' => false], 403);
                    }

                    return redirect()->back()->with('error', 'Tidak dapat mengakses notifikasi ini');
          }

          /**
           * Mark all notifications as read
           */
          public function markAllAsRead()
          {
                    $user = Auth::user();

                    Notifikasi::where('target_role', $user->role)
                              ->where('status', 'Unread')
                              ->update(['status' => 'read']);

                    return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca');
          }

          /**
           * Delete notification
           */
          public function destroy(Notifikasi $notifikasi)
          {
                    $user = Auth::user();

                    if ($notifikasi->target_role !== $user->role) {
                              abort(403, 'Unauthorized access to this notification');
                    }

                    $notifikasi->delete();

                    return redirect()->route('notifikasi.index')->with('success', 'Notifikasi berhasil dihapus');
          }

          /**
           * Get latest notifications for AJAX
           */
          public function getLatest()
          {
                    $user = Auth::user();

                    $notifs = Notifikasi::where('target_role', $user->role)
                              ->where('status', 'Unread')
                              ->latest()
                              ->take(5)
                              ->get();

                    return response()->json($notifs);
          }
}
