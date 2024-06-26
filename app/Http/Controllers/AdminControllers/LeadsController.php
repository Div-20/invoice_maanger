<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\LeadManagements;
use Illuminate\Http\Request;

class LeadsController extends Controller
{
    /** 
     * Get all contact us records
     * @param Illuminate\Http\Request $request
     */
    public function contact_us(Request $request)
    {
        $aQuery = $request->query();
        $aRows = LeadManagements::select('*')->filter()->where('type', LeadManagements::TYPE_CONTACT)->orderBy('id', 'desc')->paginate(request('paginate') ?: 20);
        return view('admin.leads-manager.contact-us', compact('aRows', 'aQuery'));
    }

    /** 
     * Get contact us records details
     * @param string $lead_id
     */
    public function view_leads($lead_id)
    {
        $aRow = LeadManagements::select('*')->where('unique_id', $lead_id)->first();
        if (!$aRow) {
            return redirect()->back()->withError('Invalid request');
        }
        return view('admin.leads-manager.manage-leads', compact('aRow'));
    }

    /** 
     * Get all newsletter records
     * @param Illuminate\Http\Request $request
     */
    public function newsletter(Request $request)
    {
        $aQuery = $request->query();
        $aRows = LeadManagements::select('*')->filter()->where('type', LeadManagements::TYPE_NEWSLETTER)->orderBy('id', 'desc')->paginate(request('paginate') ?: 20);
        return view('admin.leads-manager.newsletter', compact('aRows', 'aQuery'));
    }
}
