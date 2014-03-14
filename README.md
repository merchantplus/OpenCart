OpenCart
========

***Integrate OpenCart with the MerchantPlus NaviGate Gateway***
----------------------------------------

1. Merchant Plus API Credentials

In order to accept Credit Card payments on your website you must first register for a MerchantPlus NaviGate account. Please do so at http://www.merchantplus.com/get-started
Once you've been approved for your account, MerchantPlus will provide you with a NaviGate login and password. 

	- Login to your gateway at https://gateway.merchantplus.com/
	- Click to the "Profile & Settings" and then the "Security" sub page
	- Scroll down and click to "Edit" your transaction key and then "Generate a new Key"
	- You will use this transaction key plus your NaviGate login ID when configuring the plugin inside of OpenCart

Without the above credentials you will not be able to accept payment via the MerchantPlus NaviGate plugin.

2. OpenCart Settings

	- Download the NaviGate Module payment module from:
	- Upload the files to your OpenCart directory.
	- Sign in to your OpenCart admin.
	- Click **Extensions** tab and **Payments sub tab**.
	- Under **MerchantPlus NaviGate** click **Install** and then click **Edit**.
	- Enter your **NaviGate Username** into the 'Login ID' field.
	- Enter your **NaviGate Transaction Key** into the 'Transaction Key' field.
	- Select **Live** under **Transaction Server**.
	- Select **Live** under **Transaction Mode**.
	- Select **Capture** under **Transaction Method**.
	- You may leave the **Total** field empty.
	- Select **Complete** under **Order Status**.
	- Select **All Zones** under **Geo Zone**
	- Select **Enabled** under **Status**.
	- Save your changes.

3. ***IMPORTANT** TEST & LIVE Modes

The configuration above sets your account to perform ***LIVE*** transactions, meaning, real money is exchanged and fees are deducted. 
If you'd like to ***TEST*** transactions first, follow these steps:

	- Login to OpenCart Admin > Extensions > Payments, Edit *MerchantPlus NaviGate*
	- Select **TEST** under **Transaction Server**
	- Select **TEST** under **Transaction Mode**
	- Save Changes
	
	- Login to NaviGate > Profiles and Settings > Account Mode > Edit
	- Select **TEST** mode.
	- Save Changes.
	
	- Note that **TEST** transactions will only appear when NaviGate is set to **TEST*
