<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\PortfolioItem;
use App\Models\BlogPost;
use App\Models\Testimonial;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function getServices() {
        return response()->json(Service::all());
    }

    public function getPortfolio() {
        $items = PortfolioItem::all()->map(function($item) {
            if ($item->image_url) {
                $item->image_url = asset($item->image_url);
            }
            return $item;
        });
        return response()->json($items);
    }

    public function getBlog() {
        $posts = BlogPost::latest()->get()->map(function($post) {
            if ($post->featured_image) {
                // Check if it's already a full URL or a local path
                if (!filter_var($post->featured_image, FILTER_VALIDATE_URL)) {
                    $post->featured_image = asset($post->featured_image);
                }
            }
            return $post;
        });
        return response()->json($posts);
    }

    public function getTestimonials() {
        $testimonials = Testimonial::all()->map(function($t) {
            if ($t->image_url && !filter_var($t->image_url, FILTER_VALIDATE_URL)) {
                $t->image_url = asset($t->image_url);
            }
            return $t;
        });
        return response()->json($testimonials);
    }

    public function getTeam() {
        $members = TeamMember::orderBy('order')->get()->map(function($m) {
            if ($m->image_url && !filter_var($m->image_url, FILTER_VALIDATE_URL)) {
                $m->image_url = asset($m->image_url);
            }
            if ($m->cv_url && !filter_var($m->cv_url, FILTER_VALIDATE_URL)) {
                $m->cv_url = asset($m->cv_url);
            }
            return $m;
        });
        return response()->json($members);
    }

    // Services CRUD
    public function storeService(Request $request) {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'icon' => 'nullable|string',
            'color' => 'nullable|string'
        ]);
        return response()->json(Service::create($validated), 201);
    }

    public function updateService(Request $request, $id) {
        $service = Service::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'icon' => 'nullable|string',
            'color' => 'nullable|string'
        ]);
        $service->update($validated);
        return response()->json($service);
    }

    public function deleteService($id) {
        Service::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    // Portfolio CRUD
    public function storePortfolio(Request $request) {
        $validated = $request->validate([
            'title' => 'required|string',
            'client_name' => 'nullable|string',
            'description' => 'required|string',
            'category' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'project_url' => 'nullable|string'
        ]);

        $data = $validated;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/portfolio'), $name);
            $data['image_url'] = '/uploads/portfolio/' . $name;
        }

        unset($data['image']);
        return response()->json(PortfolioItem::create($data), 201);
    }

    public function updatePortfolio(Request $request, $id) {
        $item = PortfolioItem::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string',
            'client_name' => 'nullable|string',
            'description' => 'required|string',
            'category' => 'nullable|string',
            'image' => 'nullable', // Could be file or string if not changing
            'project_url' => 'nullable|string'
        ]);

        $data = $validated;
        
        if ($request->hasFile('image')) {
            // Delete old image
            if ($item->image_url && file_exists(public_path($item->image_url))) {
                @unlink(public_path($item->image_url));
            }

            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/portfolio'), $name);
            $data['image_url'] = '/uploads/portfolio/' . $name;
        }

        unset($data['image']);
        $item->update($data);
        return response()->json($item);
    }

    public function deletePortfolio($id) {
        $item = PortfolioItem::findOrFail($id);
        
        // Delete image file
        if ($item->image_url && file_exists(public_path($item->image_url))) {
            @unlink(public_path($item->image_url));
        }

        $item->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    // Blog CRUD
    public function storeBlog(Request $request) {
        $validated = $request->validate([
            'title' => 'required|string',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|string',
            'category' => 'nullable|string'
        ]);
        return response()->json(BlogPost::create($validated), 201);
    }

    public function updateBlog(Request $request, $id) {
        $post = BlogPost::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|string',
            'category' => 'nullable|string'
        ]);
        $post->update($validated);
        return response()->json($post);
    }

    public function deleteBlog($id) {
        BlogPost::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    // Testimonials CRUD
    public function storeTestimonial(Request $request) {
        $validated = $request->validate([
            'client_name' => 'required|string',
            'company' => 'nullable|string',
            'feedback' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|image|max:5120'
        ]);

        $data = $validated;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/testimonials'), $name);
            $data['image_url'] = '/uploads/testimonials/' . $name;
        }

        unset($data['image']);
        return response()->json(Testimonial::create($data), 201);
    }

    public function updateTestimonial(Request $request, $id) {
        $testimonial = Testimonial::findOrFail($id);
        $validated = $request->validate([
            'client_name' => 'required|string',
            'company' => 'nullable|string',
            'feedback' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable' // File or string
        ]);

        $data = $validated;
        if ($request->hasFile('image')) {
            // Delete old image
            if ($testimonial->image_url && file_exists(public_path($testimonial->image_url))) {
                @unlink(public_path($testimonial->image_url));
            }

            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/testimonials'), $name);
            $data['image_url'] = '/uploads/testimonials/' . $name;
        }

        unset($data['image']);
        $testimonial->update($data);
        return response()->json($testimonial);
    }

    public function deleteTestimonial($id) {
        $testimonial = Testimonial::findOrFail($id);
        
        // Delete image file
        if ($testimonial->image_url && file_exists(public_path($testimonial->image_url))) {
            @unlink(public_path($testimonial->image_url));
        }

        $testimonial->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    public function storeLead(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'subject' => 'nullable|string',
            'message' => 'required|string'
        ]);
        \App\Models\Lead::create($validated);
        return response()->json(['message' => 'Lead received successfully'], 201);
    }

    // Team Members CRUD
    public function storeTeamMember(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string',
            'role' => 'required|string',
            'bio' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'twitter' => 'nullable|string',
            'github' => 'nullable|string',
            'order' => 'nullable|integer',
            'image' => 'nullable|image|max:5120',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:10240'
        ]);

        $data = $validated;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/team'), $name);
            $data['image_url'] = '/uploads/team/' . $name;
        }

        if ($request->hasFile('cv')) {
            $file = $request->file('cv');
            $name = time() . '_cv_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/team/cv'), $name);
            $data['cv_url'] = '/uploads/team/cv/' . $name;
        }

        unset($data['image']);
        unset($data['cv']);
        return response()->json(TeamMember::create($data), 201);
    }

    public function updateTeamMember(Request $request, $id) {
        $member = TeamMember::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string',
            'role' => 'required|string',
            'bio' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'twitter' => 'nullable|string',
            'github' => 'nullable|string',
            'order' => 'nullable|integer',
            'image' => 'nullable', // File or string
            'cv' => 'nullable' // File or string
        ]);

        $data = $validated;
        if ($request->hasFile('image')) {
            // Delete old image
            if ($member->image_url && file_exists(public_path($member->image_url))) {
                @unlink(public_path($member->image_url));
            }

            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/team'), $name);
            $data['image_url'] = '/uploads/team/' . $name;
        }

        if ($request->hasFile('cv')) {
            // Delete old CV
            if ($member->cv_url && file_exists(public_path($member->cv_url))) {
                @unlink(public_path($member->cv_url));
            }

            $file = $request->file('cv');
            $name = time() . '_cv_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/team/cv'), $name);
            $data['cv_url'] = '/uploads/team/cv/' . $name;
        }

        unset($data['image']);
        unset($data['cv']);
        $member->update($data);
        return response()->json($member);
    }

    public function deleteTeamMember($id) {
        $member = TeamMember::findOrFail($id);
        
        // Delete image file
        if ($member->image_url && file_exists(public_path($member->image_url))) {
            @unlink(public_path($member->image_url));
        }

        // Delete CV file
        if ($member->cv_url && file_exists(public_path($member->cv_url))) {
            @unlink(public_path($member->cv_url));
        }

        $member->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    // Leads / Contacts
    public function getLeads() {
        return response()->json(\App\Models\Lead::latest()->get());
    }

    public function deleteLead($id) {
        \App\Models\Lead::findOrFail($id)->delete();
        return response()->json(['message' => 'Inquiry deleted successfully']);
    }
}
