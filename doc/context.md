
# **TechNest: Portfolio Builder** 🚀

## **👤 User Flow (Fresh Graduate / Programmer)**  

### **1️⃣ User Registration & Login**  
1. **Visit Homepage** → Sees a call-to-action to "Build Your Portfolio Now."  
2. **Click "Sign Up"** → Fills out Name, Email, Password.  
3. **Logs In** → Redirected to **Dashboard**.  

---

### **2️⃣ Dashboard Overview**  
Upon login, the user sees:  
✅ **"Create Portfolio" Button**  
✅ **List of Created Portfolios** (Paginated)  
✅ **"Import GitHub Projects" Feature**  
✅ **Premium & Free Templates Section**  

---

### **3️⃣ Creating a Portfolio**  
1. Click **"Create Portfolio"**.  
2. Fill in **Portfolio Name** & Select a **Template**.  
3. Click **"Continue"** → Redirects to **Portfolio Editor**.  

---

### **4️⃣ Editing Portfolio (Portfolio Editor Page)**  
Inside the editor, the user can:  
✅ Add/Edit:  
   - **Personal Info** (Name, Title, Bio, Contact)  
   - **Skills** (Programming Languages, Tools, Frameworks)  
   - **Experience & Projects** (Option to Import from GitHub)  
   - **Education & Certifications**  

✅ **Preview Template in Real-Time (Livewire)**.  

✅ Click **"Save Changes"** → Auto-saves progress.  

✅ Click **"Download Portfolio as ZIP"** (Includes HTML + TailwindCSS).  

---

### **5️⃣ Importing GitHub Projects**  
1. Click **"Import from GitHub"** inside the Portfolio Editor.  
2. Enter **GitHub Username** → Fetches repositories.  
3. User selects projects to **add to their portfolio**.  
4. Click **"Import"** → Projects appear in the portfolio.  

---

### **6️⃣ AI-Powered Portfolio Suggestions**  
1. Click **"Generate AI Suggestions"**.  
2. AI provides:  
   - Better **summary for bio**.  
   - Optimized **skill descriptions**.  
   - Suggested **projects to highlight**.  
3. User **accepts or modifies** suggestions.  

---

### **7️⃣ Choosing a Free or Premium Template**  
1. User browses the **Template Gallery**.  
2. Clicks on a template → **Live Preview Page** loads.  
3. Selects **Free** or **Premium**:  
   - **Free** → Available instantly.  
   - **Premium** → Redirected to **PayPal Checkout**.  

---

### **8️⃣ Downloading Portfolio as ZIP**  
1. Click **"Download Portfolio"**.  
2. System generates a .zip with:  
   - **HTML Files** (Portfolio Pages)  
   - **TailwindCSS / CSS**  
   - **Assets (Images, Icons, Fonts)**  
3. .zip file downloads instantly.  

---

### **9️⃣ User Profile & Portfolio Management**  
1. **User Dashboard** → View all created portfolios.  
2. Options for each portfolio:  
   - **Edit**  
   - **Delete**  
   - **Download Again**  
3. User **logs out** when done.  

---

## **🎩 Admin Flow (TechNest Management Panel)**  

### **1️⃣ Admin Login & Dashboard**  
1. Admin logs in via /admin.  
2. Admin dashboard displays:  
   ✅ **Total Users**  
   ✅ **Total Portfolios Created**  
   ✅ **Number of Template Downloads**  
   ✅ **Latest Activity Log**  

---

### **2️⃣ Managing Templates**  
1. Admin can **upload & manage templates**:  
   - **Add new templates (Free/Premium)**.  
   - **Upload custom thumbnail previews**.  
   - **Set prices for premium templates**.  
   - **Delete or Update templates**.  

---

### **3️⃣ Tracking User Activity & Purchases**  
1. **View Recent Downloads & Purchases**.  
2. Track **who downloaded what template & when**.  
3. View **PayPal purchase records**.  

---

### **4️⃣ Managing Users**  
1. View **User List**.  
2. View **User Activity Logs** (portfolio creation, downloads).  
3. **Ban / Disable Accounts (if needed)**.  

---

## **🌎 Website Structure & Navigation**  

### **🔹 Public Pages (Before Login)**  
- 🏠 **Home Page** → Introduction, CTA to sign up.  
- 🎨 **Template Gallery** → Browse free & premium templates.  
- 🔐 **Login / Register**.  

### **🔹 Private Pages (After Login)**  
- 📌 **User Dashboard** → View & manage portfolios.  
- 📝 **Portfolio Editor** → Create, edit, preview portfolios.  
- ⚡ **AI Suggestions Page** → Optimize portfolio content.  
- 🛒 **Template Purchase Page** → PayPal integration for premium templates.  

### **🔹 Admin Pages**  
- 🏠 **Admin Dashboard** → View analytics & manage platform.  
- 🎨 **Template Manager** → Upload & manage templates.  
- 👥 **User Management** → View & manage users.  
- 📊 **Download & Purchase Logs**.  

---

## **🎯 Final User Journey (Step-by-Step Flow)**  

**🟢 1. User visits TechNest** → Browses templates.  
**🟢 2. Signs up & logs in** → Redirected to dashboard.  
**🟢 3. Creates a new portfolio** → Selects template.  
**🟢 4. Edits portfolio** → Adds skills, projects (GitHub), AI suggestions.  
**🟢 5. Previews portfolio** → Makes final tweaks.  
**🟢 6. Downloads as ZIP** → Saves it locally.  
**🟢 7. If premium template is selected** → Pays via PayPal → Unlocks & downloads.  
**🟢 8. User manages portfolios** → Can edit, delete, or redownload.  