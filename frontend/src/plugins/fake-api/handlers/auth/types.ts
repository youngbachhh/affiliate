export type Actions = "create" | "read" | "update" | "delete" | "manage";

export type Subjects = "Auth" | "Admin" | "AclDemo" | "all";

export interface UserAbilityRule {
  action: Actions;
  subject: Subjects;
}

export interface User {
  id: number;
  fullName?: string;
  username: string;
  password: string;
  avatar?: string;
  email: string;
  role: string;
  abilityRules: UserAbilityRule[];
}

// export interface User {
//   id: number;
//   name?: string;
//   phone: string;
//   password: string;
//   // avatar?: string;
//   referral_code: string;
//   referral_id?: string;
//   email: string;
//   role_id: number;
//   is_active: boolean;
//   abilityRules: UserAbilityRule[];
// }

export interface UserOut {
  userAbilityRules: User["abilityRules"];
  accessToken: string;
  userData: Omit<User, "abilities" | "password">;
}

export interface LoginResponse {
  accessToken: string;
  userData: User;
  userAbilityRules: User["abilityRules"];
}

export interface RegisterResponse {
  accessToken: string;
  userData: User;
  userAbilityRules: User["abilityRules"];
}
