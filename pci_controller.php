<?php 

/**
 * PCI module class
 *
 * @package munkireport
 * @author tuxudo
 **/
class PCI_controller extends Module_controller
{
	
	/*** Protect methods with auth! ****/
	function __construct()
	{
		// Store module path
		$this->module_path = dirname(__FILE__);
	}

	/**
	 * Default method
	 * @author avb
	 *
	 **/
	function index()
	{
		echo "You've loaded the pci module!";
	}

   /**
     * Get PCI device names for widget
     *
     * @return void
     * @author tuxudo
     **/
     public function get_pci_devices()
     {
        $obj = new View();

        if (! $this->authorized()) {
            $obj->view('json', array('msg' => array('error' => 'Not authenticated')));
            return;
        }
        
        $usb = new PCI_model;
        $obj->view('json', array('msg' => $usb->get_pci_devices()));
     }
    
   /**
     * Retrieve data in json format
     *
     **/
    public function get_data($serial_number = '')
    {
        $obj = new View();

        if (! $this->authorized()) {
            $obj->view('json', array('msg' => 'Not authorized'));
            return;
        }
        
        $queryobj = new PCI_model();
        
        $sql = "SELECT name, vendor, sppci_device_type
                        FROM pci 
                        WHERE serial_number = '$serial_number'";
        
        $pci_tab = $queryobj->query($sql);

        $obj->view('json', array('msg' => current(array('msg' => $pci_tab)))); 
    }
		
} // END class PCI_controller
